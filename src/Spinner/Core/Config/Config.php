<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\Contract\ACharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

final class Config implements IConfig
{
    /**
     * @throws LogicException|InvalidArgumentException
     */
    public function __construct(
        protected readonly IDriver $driver,
        protected readonly IContainer $container,
        protected readonly ITwirlerFactory $twirlerFactory,
        protected readonly ITwirlerBuilder $twirlerBuilder,
        protected readonly IStyleFrameCollectionFactory $styleFrameCollectionFactory,
        protected readonly ICharFrameCollectionFactory $charFrameCollectionFactory,
        protected readonly null|int|float $shutdownDelay,
        protected readonly string $interruptMessage,
        protected readonly string $finalMessage,
        protected readonly bool $synchronous,
        protected readonly ?ILoop $loop,
        protected readonly int $colorSupportLevel,
        protected readonly bool $createInitialized,
        protected readonly array $spinnerStylePattern,
        protected readonly array $spinnerCharPattern,
        protected readonly ICharFrame $spinnerTrailingSpacer,
    ) {
        $this->assert();
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function assert(): void
    {
        $this->assertShutdownDelay();
        $this->assertRunMode();
        $this->assertExitMessage();
        $this->assertColorSupportLevel();
        $this->assertInterruptMessage();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertShutdownDelay(): void
    {
        if (null === $this->shutdownDelay) {
            return;
        }
        if (0 > $this->shutdownDelay) {
            throw new  InvalidArgumentException('Shutdown delay can not be negative.');
        }
//        if (0 === $this->shutdownDelay || 0.0 === $this->shutdownDelay) {
//            throw new  InvalidArgumentException('Shutdown delay can not be equal to 0.');
//        }
        if (Defaults::getMaxShutdownDelay() < $this->shutdownDelay) {
            throw new InvalidArgumentException(
                sprintf(
                    'Shutdown delay [%s] can not be greater than [%s].',
                    $this->shutdownDelay,
                    Defaults::getMaxShutdownDelay()
                )
            );
        }
    }

    /**
     * @throws LogicException
     */
    protected function assertRunMode(): void
    {
        if (null === $this->loop && $this->isAsynchronous()) {
            throw new LogicException(
                'You have chosen asynchronous mode configuration. It requires ILoop implementation to run.'
            );
        }
        if ($this->loop instanceof ILoop && $this->isSynchronous()) {
            throw new LogicException(
                'You have chosen synchronous mode configuration. Do not pass ILoop object.'
            );
        }
    }

    public function isAsynchronous(): bool
    {
        return !$this->isSynchronous();
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    protected function assertExitMessage(): void
    {
        // TODO (2022-06-12 19:22) [Alec Rabbit]: Add exit message validation.
    }

    protected function assertColorSupportLevel(): void
    {
        if (!in_array($this->colorSupportLevel, Defaults::getColorSupportLevels(), true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Color support level [%s] is not supported. Supported levels are: [%s].',
                    $this->colorSupportLevel,
                    implode(', ', Defaults::getColorSupportLevels())
                )
            );
        }
    }

    /**
     * @throws LogicException
     */
    protected function assertInterruptMessage(): void
    {
        if (null === $this->interruptMessage && $this->isSynchronous()) {
            return;
        }
        if (null === $this->interruptMessage && $this->isAsynchronous()) {
            throw new LogicException(
                'You have chosen asynchronous mode configuration. It requires interrupt message.'
            );
        }
        // TODO (2022-06-13 13:50) [Alec Rabbit]: Add interrupt message validation.
    }

    public function getInterruptMessage(): string
    {
        return $this->interruptMessage;
    }

    public function getFinalMessage(): string
    {
        return $this->finalMessage;
    }

    /**
     * @throws LogicException
     */
    public function getLoop(): ILoop
    {
        if ($this->isAsynchronous()) {
            return $this->loop;
        }
        throw self::synchronousModeException('loop object');
    }

    protected static function synchronousModeException(string $reason): LogicException
    {
        return new LogicException(sprintf('Configured for synchronous run mode. No %s is available.', $reason));
    }

    /**
     * @throws LogicException
     */
    public function getShutdownDelay(): int|float
    {
        if ($this->isAsynchronous()) {
            return $this->shutdownDelay;
        }
        throw self::synchronousModeException('shutdown delay');
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }

    public function getColorSupportLevel(): int
    {
        return $this->colorSupportLevel;
    }

    public function getContainer(): IContainer
    {
        return $this->container;
    }

    public function getTwirlerFactory(): ITwirlerFactory
    {
        return $this->twirlerFactory;
    }

    public function getStyleFrameCollectionFactory(): IStyleFrameCollectionFactory
    {
        return $this->styleFrameCollectionFactory;
    }

    public function getCharFrameCollectionFactory(): ICharFrameCollectionFactory
    {
        return $this->charFrameCollectionFactory;
    }

    public function getTwirlerBuilder(): ITwirlerBuilder
    {
        return $this->twirlerBuilder;
    }

    public function forMultiSpinner(): bool
    {
        return $this->container->wasCreatedEmpty();
    }

    public function createInitialized(): bool
    {
        return $this->createInitialized;
    }

    public function getSpinnerStylePattern(): array
    {
        return $this->spinnerStylePattern;
    }

    public function getSpinnerCharPattern(): array
    {
        return $this->spinnerCharPattern;
    }

    public function getSpinnerTrailingSpacer(): ICharFrame
    {
        return $this->spinnerTrailingSpacer;
    }
}
