<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Config\Builder;

use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Kernel\Config\Builder\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Kernel\Config\Config;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\IDriver;
use AlecRabbit\Spinner\Kernel\Contract\ILoop;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Contract\WIStyleProvider;
use AlecRabbit\Spinner\Kernel\Driver;
use AlecRabbit\Spinner\Kernel\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Kernel\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Kernel\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Kernel\Factory\LoopFactory;
use AlecRabbit\Spinner\Kernel\Factory\WigglerContainerFactory;
use AlecRabbit\Spinner\Kernel\Output\StreamOutput;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\Writer;
use AlecRabbit\Spinner\Kernel\WStyleProvider;

use const STDERR;

final class ConfigBuilder implements IConfigBuilder
{
    private const MESSAGE_ON_SIGINT = Defaults::MESSAGE_ON_EXIT;
    private const MESSAGE_INTERRUPTED = Defaults::MESSAGE_INTERRUPTED;
    private const FINAL_MESSAGE = Defaults::FINAL_MESSAGE;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;
    private const HIDE_CURSOR = Defaults::HIDE_CURSOR;
    private const SYNCHRONOUS_MODE = Defaults::SYNCHRONOUS_MODE;

    private ?ILoop $loop = null;
    private ?bool $hideCursor = null;
    private ?IDriver $driver = null;
    private ?IWigglerContainer $wigglers = null;
    private ?bool $synchronousMode = null;
    private ?float $shutdownDelaySeconds = null;
    private ?string $interruptMessage = null;
    private ?string $finalMessage = null;
    private ?IWFrameCollection $frames = null;
    private ?IWInterval $interval = null;
    private ?int $terminalColorSupport = null;
    private ?ILoopFactory $loopFactory = null;
    private ?IWigglerContainerFactory $wigglerContainerFactory = null;
    private ?IWigglerFactory $wigglerFactory = null;
    private ?WIStyleProvider $styleRenderer = null;
    private ?IStylePatternExtractor $stylePatternExtractor = null;

    public function withWigglerContainerFactory(IWigglerContainerFactory $wigglerContainerFactory): self
    {
        $clone = clone $this;
        $clone->wigglerContainerFactory = $wigglerContainerFactory;
        return $clone;
    }

    public function withStylePatternExtractor(IStylePatternExtractor $stylePatternExtractor): self
    {
        $clone = clone $this;
        $clone->stylePatternExtractor = $stylePatternExtractor;
        return $clone;
    }

    public function withStyleRenderer(WIStyleProvider $styleRenderer): self
    {
        $clone = clone $this;
        $clone->styleRenderer = $styleRenderer;
        return $clone;
    }

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

    public function withCursor(): self
    {
        $clone = clone $this;
        $clone->hideCursor = false;
        return $clone;
    }

    public function withInterval(IWInterval $interval): self
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withFrames(IWFrameCollection $frames): self
    {
        $clone = clone $this;
        $clone->frames = $frames;
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
                wigglers: $this->wigglers,
                shutdownDelay: $this->shutdownDelaySeconds,
                interruptMessage: $this->interruptMessage,
                finalMessage: $this->finalMessage,
                synchronous: $this->synchronousMode,
                loop: $this->loop,
                colorSupportLevel: $this->terminalColorSupport,
            );
    }

    /**
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    private function processDefaults(): void
    {
        if (null === $this->hideCursor) {
            $this->hideCursor = self::HIDE_CURSOR;
        }

        if (null === $this->finalMessage) {
            $this->finalMessage = self::FINAL_MESSAGE;
        }

        if (null === $this->synchronousMode) {
            $this->synchronousMode = self::SYNCHRONOUS_MODE;
        }

        if (!$this->synchronousMode) {
            if (null === $this->shutdownDelaySeconds) {
                $this->shutdownDelaySeconds = self::SHUTDOWN_DELAY;
            }
            if (null === $this->interruptMessage) {
                $this->interruptMessage = self::MESSAGE_ON_SIGINT;
            }
        }

        if ($this->synchronousMode) {
            if (null === $this->interruptMessage) {
                $this->interruptMessage = self::MESSAGE_INTERRUPTED;
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

        if (null === $this->stylePatternExtractor) {
            $this->stylePatternExtractor = new StylePatternExtractor($this->terminalColorSupport);
        }

        if (null === $this->styleRenderer) {
            $this->styleRenderer = new WStyleProvider($this->stylePatternExtractor);
        }

        if (null === $this->wigglerContainerFactory) {
            $this->wigglerContainerFactory =
                new WigglerContainerFactory(
                    $this->styleRenderer,
                    $this->wigglerFactory,
                    $this->frames,
                    $this->interval,
                );
        }

        if (null === $this->wigglers) {
            $this->wigglers = $this->wigglerContainerFactory->createContainer();
        }
    }

    private function createDriver(): IDriver
    {
        return
            new Driver(
                new Writer(
                    new StreamOutput(STDERR)
                ),
                $this->hideCursor,
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
