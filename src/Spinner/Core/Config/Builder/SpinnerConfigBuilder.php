<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\Contract\ISpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Contract\IWriter;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Factory\WigglerContainerFactory;
use AlecRabbit\Spinner\Core\FrameContainer;
use AlecRabbit\Spinner\Core\Output\StdErrOutput;
use AlecRabbit\Spinner\Core\Renderer;
use AlecRabbit\Spinner\Core\StrSplitter;
use AlecRabbit\Spinner\Core\Writer;

final class SpinnerConfigBuilder implements ISpinnerConfigBuilder
{
    private const MESSAGE_ON_EXIT = Defaults::MESSAGE_ON_EXIT;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;
    private const DEFAULT_FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;

    private ?ILoop $loop = null;
    private ?IDriver $driver = null;
    private ?IWigglerContainer $wigglers = null;
    private ?bool $synchronousMode = null;
    private ?float $shutdownDelaySeconds = null;
    private ?string $exitMessage = null;
    private ?IFrameContainer $frames = null;

    public function withExitMessage(string $exitMessage): self
    {
        $clone = clone $this;
        $clone->exitMessage = $exitMessage;
        return $clone;
    }

    public function withShutdownDelayMicroseconds(int $shutdownDelay): self
    {
        $clone = clone $this;
        $clone->shutdownDelaySeconds = round($shutdownDelay / 1000, 3);
        return $clone;
    }

    public function withLoop(ILoop $loop): self
    {
        $clone = clone $this;
        $clone->loop = $loop;
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

    /**
     * @throws InvalidArgumentException
     */
    public function withFrames(IFrameContainer|iterable|string $frames, ?int $elementWidth = null): self
    {
        $clone = clone $this;
        $clone->frames = self::refineFrames($frames, $elementWidth);
        return $clone;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function refineFrames(
        IFrameContainer|iterable|string $frames = self::DEFAULT_FRAME_SEQUENCE,
        ?int $elementWidth = null
    ): IFrameContainer {
        if ($frames instanceof IFrameContainer) {
            return $frames;
        }
        return FrameContainer::create($frames, $elementWidth);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): ISpinnerConfig
    {
        if (null === $this->driver) {
            $this->driver = self::createDriver();
        }

        if (null === $this->frames) {
            $this->frames = self::refineFrames();
        }

        if (null === $this->wigglers) {
            $this->wigglers = self::createWigglerContainer($this->frames);
        }

        if (null === $this->shutdownDelaySeconds) {
            $this->shutdownDelaySeconds = self::SHUTDOWN_DELAY;
        }

        if (null === $this->exitMessage) {
            $this->exitMessage = self::MESSAGE_ON_EXIT;
        }

        if (null === $this->synchronousMode) {
            $this->synchronousMode = false;
        }

        if (null === $this->loop) {
            $this->loop = self::getLoop();
        }

        $this->loop = self::refineLoop($this->loop, $this->synchronousMode);

        return
            new SpinnerConfig(
                driver: $this->driver,
                wigglers: $this->wigglers,
                shutdownDelay: $this->shutdownDelaySeconds,
                exitMessage: $this->exitMessage,
                synchronous: $this->synchronousMode,
                loop: $this->loop,
            );
    }

    private static function createDriver(): IDriver
    {
        return
            new Driver(
                self::createWriter(),
                self::createRenderer(),
            );
    }

    private static function createWriter(): IWriter
    {
        return new Writer(new StdErrOutput());
    }

    private static function createRenderer(): IRenderer
    {
        return
            new Renderer();
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createWigglerContainer(IFrameContainer $frames): IWigglerContainer
    {
        return
            WigglerContainerFactory::create($frames);
    }

    /**
     * @throws DomainException
     */
    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

    private static function refineLoop(ILoop $loop, bool $synchronous): ?ILoop
    {
        if ($synchronous) {
            return null;
        }
        return $loop;
    }
}
