<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\CharPatternExtractor;
use AlecRabbit\Spinner\Core\Collection\Factory\CharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\StyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Config\Builder\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\CharProvider;
use AlecRabbit\Spinner\Core\Contract\ICharPatternExtractor;
use AlecRabbit\Spinner\Core\Contract\ICharProvider;
use AlecRabbit\Spinner\Core\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Contract\IStyleProvider;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Frame\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Core\Frame\Factory\StyleFrameFactory;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\IntervalVisitor;
use AlecRabbit\Spinner\Core\LoopFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Core\StyleProvider;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Builder\TwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerContainerFactory;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;
use AlecRabbit\Spinner\Core\Twirler\Factory\TwirlerContainerFactory;
use AlecRabbit\Spinner\Core\Twirler\Factory\TwirlerFactory;
use AlecRabbit\Spinner\Core\Twirler\TwirlerRenderer;
use AlecRabbit\Spinner\Core\Writer;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

use const STDERR;

final class ConfigBuilder implements IConfigBuilder
{
    private ?ILoop $loop = null;
    private ?bool $hideCursor = null;
    private ?bool $createEmpty = null;
    private ?bool $createInitialized = null;
    private ?IDriver $driver = null;
    private ?IContainer $container = null;
    private ?IIntervalVisitor $intervalVisitor = null;
    private ?ITwirlerFactory $twirlerFactory = null;
    private ?ITwirlerBuilder $twirlerBuilder = null;
    private ?ITwirlerContainerFactory $containerFactory = null;
    private ?bool $synchronousMode = null;
    private ?float $shutdownDelaySeconds = null;
    private ?string $interruptMessage = null;
    private ?string $finalMessage = null;
    private ?int $terminalColorSupport = null;
    private ?ILoopFactory $loopFactory = null;
    private ?IStyleProvider $styleProvider = null;
    private ?ICharProvider $charProvider = null;
    private ?IStylePatternExtractor $stylePatternExtractor = null;
    private ?ICharPatternExtractor $charPatternExtractor = null;
    private ?IStyleFrameCollectionFactory $styleFrameCollectionFactory = null;
    private ?ICharFrameCollectionFactory $charFrameCollectionFactory = null;
    private ?array $spinnerStylePattern = null;
    private ?array $spinnerCharPattern = null;
    private ?ICharFrame $spinnerTrailingSpacer = null;

    private ?IInterval $interval = null;

    public function withInterruptMessage(string $interruptMessage): self
    {
        $clone = clone $this;
        $clone->interruptMessage = $interruptMessage;
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

    public function withTerminalColor(int $terminalColorSupport): self
    {
        $clone = clone $this;
        $clone->terminalColorSupport = $terminalColorSupport;
        return $clone;
    }

    public function createInitialized(): self
    {
        $clone = clone $this;
        $clone->createInitialized = true;
        return $clone;
    }

    public function inSynchronousMode(): self
    {
        $clone = clone $this;
        $clone->synchronousMode = true;
        return $clone;
    }

    public function withCursor(): self
    {
        $clone = clone $this;
        $clone->hideCursor = false;
        return $clone;
    }

    public function withDriver(IDriver $driver): self
    {
        $clone = clone $this;
        $clone->driver = $driver;
        return $clone;
    }

    public function withTwirlerFactory(ITwirlerFactory $twirlerFactory): self
    {
        $clone = clone $this;
        $clone->twirlerFactory = $twirlerFactory;
        return $clone;
    }

    public function withTwirlerBuilder(ITwirlerBuilder $twirlerBuilder): self
    {
        $clone = clone $this;
        $clone->twirlerBuilder = $twirlerBuilder;
        return $clone;
    }

    public function withContainerFactory(ITwirlerContainerFactory $containerFactory): self
    {
        $clone = clone $this;
        $clone->containerFactory = $containerFactory;
        return $clone;
    }

    public function withStyleProvider(IStyleProvider $styleProvider): self
    {
        $clone = clone $this;
        $clone->styleProvider = $styleProvider;
        return $clone;
    }

    public function withCharProvider(ICharProvider $charProvider): self
    {
        $clone = clone $this;
        $clone->charProvider = $charProvider;
        return $clone;
    }

    public function withStyleFrameCollectionFactory(IStyleFrameCollectionFactory $styleFrameCollectionFactory): self
    {
        $clone = clone $this;
        $clone->styleFrameCollectionFactory = $styleFrameCollectionFactory;
        return $clone;
    }

    public function withCharFrameCollectionFactory(ICharFrameCollectionFactory $charFrameCollectionFactory): self
    {
        $clone = clone $this;
        $clone->charFrameCollectionFactory = $charFrameCollectionFactory;
        return $clone;
    }

    public function withCharPatternExtractor(ICharPatternExtractor $charPatternExtractor): self
    {
        $clone = clone $this;
        $clone->charPatternExtractor = $charPatternExtractor;
        return $clone;
    }

    public function withStylePatternExtractor(IStylePatternExtractor $stylePatternExtractor): self
    {
        $clone = clone $this;
        $clone->stylePatternExtractor = $stylePatternExtractor;
        return $clone;
    }

    public function createEmpty(): self
    {
        $clone = clone $this;
        $clone->createEmpty = true;
        return $clone;
    }

    public function withContainer(IContainer $container): self
    {
        $clone = clone $this;
        $clone->container = $container;
        return $clone;
    }

    public function withIntervalVisitor(IIntervalVisitor $intervalVisitor): self
    {
        $clone = clone $this;
        $clone->intervalVisitor = $intervalVisitor;
        return $clone;
    }

    public function withInterval(IInterval $interval): self
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }


    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig
    {
        $this->processDefaults();

        return
            new Config(
                driver: $this->driver,
                container: $this->container,
                twirlerFactory: $this->twirlerFactory,
                twirlerBuilder: $this->twirlerBuilder,
                styleFrameCollectionFactory: $this->styleFrameCollectionFactory,
                charFrameCollectionFactory: $this->charFrameCollectionFactory,
                shutdownDelay: $this->shutdownDelaySeconds,
                interruptMessage: $this->interruptMessage,
                finalMessage: $this->finalMessage,
                synchronous: $this->synchronousMode,
                loop: $this->loop,
                colorSupportLevel: $this->terminalColorSupport,
                createInitialized: $this->createInitialized,
                spinnerStylePattern: $this->spinnerStylePattern,
                spinnerCharPattern: $this->spinnerCharPattern,
                spinnerTrailingSpacer: $this->spinnerTrailingSpacer,
            );
    }

    /**
     * @throws DomainException
     */
    private function processDefaults(): void
    {
        if (null === $this->hideCursor) {
            $this->hideCursor = Defaults::getHideCursor();
        }

        if (null === $this->finalMessage) {
            $this->finalMessage = Defaults::getFinalMessage();
        }

        if (null === $this->synchronousMode) {
            $this->synchronousMode = Defaults::getSynchronousMode();
        }

        if (!$this->synchronousMode) {
            if (null === $this->shutdownDelaySeconds) {
                $this->shutdownDelaySeconds = Defaults::getShutdownDelay();
            }
            if (null === $this->interruptMessage) {
                $this->interruptMessage = Defaults::getMessageOnExit();
            }
        }

        if ($this->synchronousMode) {
            if (null === $this->interruptMessage) {
                $this->interruptMessage = Defaults::getInterruptMessage();
            }
        }

        if (null === $this->driver) {
            $this->driver = $this->createDriver();
        }

        if (null === $this->terminalColorSupport) {
            $this->terminalColorSupport = $this->driver->getTerminalColorSupport();
        }

        if (null === $this->loopFactory) {
            $this->loopFactory = new LoopFactory();
        }

        if (null === $this->loop) {
            $this->loop = $this->getLoop($this->synchronousMode);
        }

        if(null === $this->spinnerStylePattern) {
            $this->spinnerStylePattern = Defaults::getSpinnerStylePattern();
        }

        if(null === $this->spinnerCharPattern) {
            $this->spinnerCharPattern = Defaults::getSpinnerCharPattern();
        }

        if(null === $this->spinnerTrailingSpacer) {
            $this->spinnerTrailingSpacer = Defaults::getSpinnerTrailingSpacer();
        }

        if (null === $this->stylePatternExtractor) {
            $this->stylePatternExtractor = new StylePatternExtractor($this->terminalColorSupport);
        }

        if (null === $this->charPatternExtractor) {
            $this->charPatternExtractor = new CharPatternExtractor();
        }

        if (null === $this->styleProvider) {
            $this->styleProvider = new StyleProvider(new StyleFrameFactory(), $this->stylePatternExtractor);
        }

        if (null === $this->charProvider) {
            $this->charProvider = new CharProvider(new CharFrameFactory(), $this->charPatternExtractor);
        }

        if (null === $this->interval) {
            $this->interval = Interval::createDefault();
        }

        if (null === $this->styleFrameCollectionFactory) {
            $this->styleFrameCollectionFactory =
                new StyleFrameCollectionFactory(
                    $this->styleProvider,
                );
        }

        if (null === $this->charFrameCollectionFactory) {
            $this->charFrameCollectionFactory =
                new CharFrameCollectionFactory(
                    $this->charProvider,
                );
        }

        if (null === $this->intervalVisitor) {
            $this->intervalVisitor = new IntervalVisitor();
        }

        if (null === $this->twirlerBuilder) {
            $this->twirlerBuilder =
                new TwirlerBuilder(
                    $this->styleFrameCollectionFactory,
                    $this->charFrameCollectionFactory,
                );
        }

        if (null === $this->twirlerFactory) {
            $this->twirlerFactory =
                new TwirlerFactory(
                    $this->twirlerBuilder,
                );
        }

        if (null === $this->containerFactory) {
            $this->containerFactory =
                new TwirlerContainerFactory(
                    $this->interval,
                    $this->intervalVisitor,
                    $this->twirlerFactory,
                );
        }

        if (null === $this->createEmpty) {
            $this->createEmpty = false;
        }

        if (null === $this->createInitialized) {
            $this->createInitialized = false;
        }

        if (null === $this->container) {
            $this->container = $this->containerFactory->createContainer($this->createEmpty);
        }
    }

    private function createDriver(): IDriver
    {
        $output = new StreamOutput(STDERR);

        return
            new Driver(
                $this->hideCursor,
                new Writer(
                    $output
                ),
                new TwirlerRenderer($output),
            );
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
