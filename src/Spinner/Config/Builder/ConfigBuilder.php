<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Builder;

use AlecRabbit\Spinner\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IOutput;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\StdErrOutput;
use AlecRabbit\Spinner\Factory\LoopFactory;

final class ConfigBuilder
{
    private const DEFAULT_SIGINT_HANDLER_MESSAGE = 'Exiting... (CTRL+C to force)';
    private const DEFAULT_SHUTDOWN_DELAY = 0.5;

    private IOutput $output;
    private ILoop $loop;
    private bool $synchronousMode;

    public function __construct()
    {
        $this->output = new StdErrOutput();
        $this->synchronousMode = false;
        $this->loop = self::getLoop();
    }

    private static function refineLoop(ILoop $loop, bool $asyncMode): ?ILoop
    {
        if ($asyncMode) {
            return $loop;
        }
        return null;
    }

    public function withOutput(IOutput $output): self
    {
        $this->output = $output;
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
        return new SpinnerConfig(
            output: $this->output,
            loop:   self::refineLoop($this->loop, $this->synchronousMode),
            synchronous:  $this->synchronousMode,
        );
    }

    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

}
