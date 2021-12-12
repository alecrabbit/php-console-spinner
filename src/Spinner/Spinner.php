<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use React\EventLoop\Loop;

final class Spinner implements ISpinner
{
    private readonly IOutput $output;
    private \React\EventLoop\LoopInterface $loop;

    public function __construct(
        private ISpinnerConfig $configuration
    )
    {
        $this->output = new Output();
        $this->loop = Loop::get();
    }

    public function spin(): void
    {
        // render and output frame
        $this->output->write($this->render());
    }

    private function render(): string
    {
        return '*';
    }
}
