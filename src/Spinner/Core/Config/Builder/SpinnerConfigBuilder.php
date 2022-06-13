<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\Contract\ISpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Factory\WigglerContainerFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Output\StdErrOutput;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Writer;

final class SpinnerConfigBuilder implements ISpinnerConfigBuilder
{
    private const MESSAGE_ON_EXIT = Defaults::MESSAGE_ON_EXIT;
    private const FINAL_MESSAGE = Defaults::FINAL_MESSAGE;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;
    private const FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;
    private const HIDE_CURSOR = Defaults::HIDE_CURSOR;

    private ?ILoop $loop = null;
    private ?bool $hideCursor = null;
    private ?IDriver $driver = null;
    private ?IWigglerContainer $wigglers = null;
    private ?bool $synchronousMode = null;
    private ?float $shutdownDelaySeconds = null;
    private ?string $exitMessage = null;
    private ?string $finalMessage = null;
    private ?IFrameCollection $frames = null;
    private ?IInterval $interval = null;
    private ?int $terminalColorSupport = null;
    private ?ILoopFactory $loopFactory = null;
    private ?WigglerContainerFactory $wigglerContainerFactory = null;

    public function withWigglerContainerFactory(WigglerContainerFactory $wigglerContainerFactory): self
    {
        $clone = clone $this;
        $clone->wigglerContainerFactory = $wigglerContainerFactory;
        return $clone;
    }

    public function withExitMessage(string $exitMessage): self
    {
        $clone = clone $this;
        $clone->exitMessage = $exitMessage;
        return $clone;
    }

    public function withFinalMessage(string $finalMessage): self
    {
        $clone = clone $this;
        $clone->finalMessage = $finalMessage;
        return $clone;
    }

    public function withShutdownDelay(int $microseconds): self
    {
        $clone = clone $this;
        $clone->shutdownDelaySeconds = round($microseconds / 1000, 3);
        return $clone;
    }

    public function withLoopFactory(ILoopFactory $loopFactory): self
    {
        $clone = clone $this;
        $clone->loopFactory = $loopFactory;
        return $clone;
    }

    public function withLoop(ILoop $loop): self
    {
        $clone = clone $this;
        $clone->loop = $loop;
        return $clone;
    }

    public function withColorSupportLevel(int $colorSupportLevel): self
    {
        $clone = clone $this;
        $clone->terminalColorSupport = $colorSupportLevel;
        return $clone;
    }

    public function withWigglers(IWigglerContainer $wigglers): self
    {
        $clone = clone $this;
        $clone->wigglers = $wigglers;
        return $clone;
    }

    public function inSynchronousMode(): self
    {
        $clone = clone $this;
        $clone->synchronousMode = true;
        return $clone;
    }

    public function doNotHideCursor(): self
    {
        $clone = clone $this;
        $clone->hideCursor = false;
        return $clone;
    }

    public function withInterval(IInterval $interval): self
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withFrames(IFrameCollection $frames): self
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): ISpinnerConfig
    {
        $this->processDefaults();

        return
            new SpinnerConfig(
                hideCursor: $this->hideCursor,
                driver: $this->driver,
                wigglers: $this->wigglers,
                shutdownDelay: $this->shutdownDelaySeconds,
                exitMessage: $this->exitMessage,
                finalMessage: $this->finalMessage,
                synchronous: $this->synchronousMode,
                loop: $this->loop,
                interval: $this->interval,
                colorSupportLevel: $this->terminalColorSupport,
            );
    }

    /**
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    private function processDefaults(): void
    {
        if (null === $this->loopFactory) {
            $this->loopFactory = new LoopFactory();
        }
        if (null === $this->frames) {
            $this->frames = self::defaultFrames();
        }

        if (null === $this->interval) {
            $this->interval = $this->frames->getInterval();
        }

        if (null === $this->wigglerContainerFactory) {
            $this->wigglerContainerFactory = new WigglerContainerFactory($this->interval);
        }

        if (null === $this->driver) {
            $this->driver = self::createDriver();
        }

        if (null === $this->terminalColorSupport) {
            $this->terminalColorSupport = $this->driver->getTerminalColorSupport();
        }

        if (null === $this->wigglers) {
            $this->wigglers = $this->createWigglerContainer($this->frames);
        }

        if (null === $this->synchronousMode) {
            $this->synchronousMode = false;
        }

        if (null === $this->loop) {
            $this->loop = $this->getLoop($this->synchronousMode);
        }

        if (null === $this->shutdownDelaySeconds && !$this->synchronousMode) {
            $this->shutdownDelaySeconds = self::SHUTDOWN_DELAY;
        }

        if (null === $this->exitMessage && !$this->synchronousMode) {
            $this->exitMessage = self::MESSAGE_ON_EXIT;
        }

        if (null === $this->finalMessage && !$this->synchronousMode) {
            $this->finalMessage = self::FINAL_MESSAGE;
        }

        if (null === $this->hideCursor) {
            $this->hideCursor = self::HIDE_CURSOR;
        }
    }

    private static function createDriver(): IDriver
    {
        return
            new Driver(
                new Writer(
                    new StdErrOutput()
                ),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function defaultFrames(): IFrameCollection
    {
        return FrameCollection::create(...self::FRAME_SEQUENCE);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function createWigglerContainer(IFrameCollection $frames): IWigglerContainer
    {
        return
            $this->wigglerContainerFactory->create($frames);
    }

    /**
     * @throws DomainException
     */
    private function getLoop(bool $synchronousMode): ?ILoop
    {
        if ($synchronousMode) {
            return null;
        }
        try {
            return $this->loopFactory->getLoop();
        } catch (DomainException $e) {
            // TODO (2022-06-10 18:21) [Alec Rabbit]: clarify message [248e8c9c-ca5d-47bb-92d2-267b25165425]
            throw new DomainException(
                sprintf(
                    'Running mode: [%s]. %s',
                    'asynchronous',
                    $e->getMessage(),
                ),
                $e->getCode(),
                $e,
            );
        }
    }
}
