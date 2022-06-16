<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
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
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Factory\WigglerContainerFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Writer;

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
    private ?IFrameCollection $frames = null;
    private ?IInterval $interval = null;
    private ?int $terminalColorSupport = null;
    private ?ILoopFactory $loopFactory = null;
    private ?IWigglerContainerFactory $wigglerContainerFactory = null;
    private ?IWigglerFactory $wigglerFactory = null;

    public function withWigglerContainerFactory(IWigglerContainerFactory $wigglerContainerFactory): self
    {
        $clone = clone $this;
        $clone->wigglerContainerFactory = $wigglerContainerFactory;
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

        if (null === $this->wigglerContainerFactory) {
            $this->wigglerContainerFactory =
                new WigglerContainerFactory(
                    $this->wigglerFactory,
                    $this->frames,
                    $this->terminalColorSupport,
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
