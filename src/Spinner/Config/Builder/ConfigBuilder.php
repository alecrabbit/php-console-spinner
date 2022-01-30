<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Builder;

use AlecRabbit\Spinner\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\StdErrOutput;
use AlecRabbit\Spinner\Factory\LoopFactory;

final class ConfigBuilder
{
    private const MESSAGE_ON_EXIT = Defaults::MESSAGE_ON_EXIT;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;

    private ILoop $loop;
    private IDriver $driver;
    private bool $synchronousMode;
    private float $shutdownDelaySeconds;
    private string $exitMessage;

    public function __construct()
    {
        $this->synchronousMode = false;
        $this->loop = self::getLoop();
        $this->driver = self::createDriver();
        $this->exitMessage = self::MESSAGE_ON_EXIT;
        $this->shutdownDelaySeconds = self::SHUTDOWN_DELAY;
    }

    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

    private static function createDriver(): IDriver
    {
        return new Driver(new StdErrOutput());
    }

    public function withExitMessage(string $exitMessage): self
    {
        $this->exitMessage = $exitMessage;
        return $this;
    }

    public function withShutdownDelayMicroseconds(int $shutdownDelay): self
    {
        $this->shutdownDelaySeconds = round($shutdownDelay / 1000, 3);
        return $this;
    }

    public function withDriver(IDriver $driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    public function withLoop(ILoop $loop): self
    {
        $this->loop = $loop;
        return $this;
    }

    public function inSynchronousMode(): self
    {
        $this->synchronousMode = false;
        return $this;
    }

    public function build(): ISpinnerConfig
    {
        return
            new SpinnerConfig(
                driver:        $this->driver,
                shutdownDelay: $this->shutdownDelaySeconds,
                exitMessage:   $this->exitMessage,
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
