<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Builder;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Factory\LoopFactory;
use AlecRabbit\Spinner\SpinnerConfig;
use AlecRabbit\Spinner\StdErrOutput;

final class ConfigBuilder
{
    private const DEFAULT_EXIT_MESSAGE = 'Exiting... (CTRL+C to force)';
    private const DEFAULT_SHUTDOWN_DELAY = 0.5;

    private IOutput $output;
    private ILoop $loop;
    private bool $asyncMode;

    public function __construct()
    {
        $this->output = new StdErrOutput();
        $this->asyncMode = true;
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

    public function inSyncMode(): self
    {
        $this->asyncMode = false;
        return $this;
    }

    public function build(): ISpinnerConfig
    {
        return new SpinnerConfig(
            output: $this->output,
            loop:   self::refineLoop($this->loop, $this->asyncMode),
            async:  $this->asyncMode,
        );
    }

    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

}
