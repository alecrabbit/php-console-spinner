<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

use const AlecRabbit\CSI;

final class Spinner implements ISpinner
{
    private readonly IOutput $output;
    private LoopInterface $loop;

    public function __construct(
        private ISpinnerConfig $config
    ) {
        $this->output = $config->getOutput();
        $this->loop = $config->getLoop();

        $this->initialize();
    }

    private function initialize(): void
    {
        // set mup spinner to work automatically
        // Add periodic timer to redraw our spinner
        $this->loop->addPeriodicTimer(
            $this->interval(),
            function () {
                $this->spin();
            }
        );
    }

    private function interval(): float
    {
        return 0.1;
    }

    public function spin(): void
    {
        // render and output frame
        $this->output->write($this->render());
    }

    private function render(): string
    {
        return '*'. CSI . '1D';
    }
}
