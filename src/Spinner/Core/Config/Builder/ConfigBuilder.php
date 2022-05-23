<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISequencer;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IWriter;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\FrameHolder;
use AlecRabbit\Spinner\Core\Renderer;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Core\StdErrOutput;
use AlecRabbit\Spinner\Core\Writer;

final class ConfigBuilder
{
    private const MESSAGE_ON_EXIT = Defaults::MESSAGE_ON_EXIT;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;

    private ILoop $loop;
//    private ISequencer $sequencer;
//    private IWriter $writer;
    private IDriver $driver;
//    private IRenderer $renderer;
    private bool $synchronousMode;
    private float $shutdownDelaySeconds;
    private string $exitMessage;

    /**
     * @throws DomainException
     */
    public function __construct()
    {
        $this->synchronousMode = false;
        $this->loop = self::getLoop();
//        $this->sequencer = self::createSequencer();
//        $this->writer = self::createWriter();
        $this->driver = self::createDriver();
//        $this->renderer = self::createRenderer();
        $this->exitMessage = self::MESSAGE_ON_EXIT;
        $this->shutdownDelaySeconds = self::SHUTDOWN_DELAY;
    }

    /**
     * @throws DomainException
     */
    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

    private static function createSequencer(): ISequencer
    {
        return new Sequencer();
    }

    private static function createWriter(): IWriter
    {
        return new Writer(new StdErrOutput());
    }

    private static function createDriver(): IDriver
    {
        return
            new Driver(
                self::createWriter(),
                self::createSequencer(),
                self::createRenderer(),
            );
    }

    private static function createRenderer(): IRenderer
    {
        return
            new Renderer(
                new Color(),
                new FrameHolder(),
            );
    }

    public function withExitMessage(string $exitMessage): self
    {
        $clone = clone $this;
        $this->exitMessage = $exitMessage;
        return $clone;
    }

    public function withShutdownDelayMicroseconds(int $shutdownDelay): self
    {
        $clone = clone $this;
        $this->shutdownDelaySeconds = round($shutdownDelay / 1000, 3);
        return $clone;
    }

    public function withSequencer(ISequencer $sequencer): self
    {
        $clone = clone $this;
        $this->sequencer = $sequencer;
        return $clone;
    }

    public function withWriter(IWriter $writer): self
    {
        $clone = clone $this;
        $this->writer = $writer;
        return $clone;
    }

    public function withRenderer(IRenderer $renderer): self
    {
        $clone = clone $this;
        $this->renderer = $renderer;
        return $clone;
    }

    public function withLoop(ILoop $loop): self
    {
        $clone = clone $this;
        $this->loop = $loop;
        return $clone;
    }

    public function inSynchronousMode(): self
    {
        $clone = clone $this;
        $this->synchronousMode = false;
        return $clone;
    }

    public function build(): ISpinnerConfig
    {
        return
            new SpinnerConfig(
//                sequencer: $this->sequencer,
//                writer: $this->writer,
                driver: $this->driver,
//                renderer: $this->renderer,
                shutdownDelay: $this->shutdownDelaySeconds,
                exitMessage: $this->exitMessage,
                loop: self::refineLoop($this->loop, $this->synchronousMode),
                synchronous: $this->synchronousMode,
            );
    }

    private static function refineLoop(ILoop $loop, bool $synchronousMode): ?ILoop
    {
        if (!$synchronousMode) {
            return $loop;
        }
        return null;
    }
}
