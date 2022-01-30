<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Builder;

use AlecRabbit\Spinner\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IOutput;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\StdErrOutput;
use AlecRabbit\Spinner\Factory\LoopFactory;
use RuntimeException;

final class ConfigBuilder
{
    private const DEFAULT_SIGINT_HANDLER_MESSAGE = 'Exiting... (CTRL+C to force)';
    private const DEFAULT_SHUTDOWN_DELAY = 0.5;

    private IOutput $output;
    private ILoop $loop;
    private string $driverClass;
    private bool $synchronousMode;

    public function __construct()
    {
        $this->output = new StdErrOutput();
        $this->synchronousMode = false;
        $this->loop = self::getLoop();
    }

    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

    public function withOutput(IOutput $output): self
    {
        $this->output = $output;
        return $this;
    }

    public function withDriverClass(string $driverCLass): self
    {
        if (is_subclass_of($driverCLass, IDriver::class)) {
            $this->driverClass = $driverCLass;
            return $this;
        }
        throw new RuntimeException(
            sprintf('Unsupported driver class [%s]', $driverCLass)
        );
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
        return new SpinnerConfig(
            output:      $this->output,
            driver:      self::getDriver($this->output),
            loop:        self::refineLoop($this->loop, $this->synchronousMode),
            synchronous: $this->synchronousMode,
        );
    }

    private static function getDriver(IOutput $output): IDriver
    {
        return new Driver($output);
    }

    private static function refineLoop(ILoop $loop, bool $synchronousMode): ?ILoop
    {
        if (!$synchronousMode) {
            return $loop;
        }
        return null;
    }

}
