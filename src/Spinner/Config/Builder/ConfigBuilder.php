<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Builder;

use AlecRabbit\Spinner\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Contract\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\FrameHolder;
use AlecRabbit\Spinner\Core\Renderer;
use AlecRabbit\Spinner\Core\StdErrOutput;
use AlecRabbit\Spinner\Factory\LoopFactory;

final class ConfigBuilder
{
    private const MESSAGE_ON_EXIT = Defaults::MESSAGE_ON_EXIT;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;

    private ILoop $loop;
    private IDriver $driver;
    private IRenderer $renderer;
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
        $this->driver = self::createDriver();
        $this->renderer = self::createRenderer();
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

    private static function createDriver(): IDriver
    {
        return new Driver(new StdErrOutput());
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

    public function withDriver(IDriver $driver): self
    {
        $clone = clone $this;
        $this->driver = $driver;
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
                driver:        $this->driver,
                shutdownDelay: $this->shutdownDelaySeconds,
                exitMessage:   $this->exitMessage,
                renderer:      $this->renderer,
                synchronous:   $this->synchronousMode,
                loop:          self::refineLoop($this->loop, $this->synchronousMode),
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
