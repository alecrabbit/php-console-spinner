<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

final class SpinnerConfig implements ISpinnerConfig
{
    private IOutput $output;
    private LoopInterface $loop;

    public function __construct()
    {
        $this->output = new Output();
        $this->loop = Loop::get();
    }

    public function getOutput(): IOutput
    {
        return $this->output;
    }

    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

}
