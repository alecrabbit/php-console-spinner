<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use React\EventLoop\LoopInterface;

use const AlecRabbit\Cli\CSI;

final class Spinner implements ISpinner
{
    private const FRAME_INTERVAL = 0.1;
    private readonly IOutput $output;
    private LoopInterface $loop;
    private bool $odd = true;

    public function __construct(
        private ISpinnerConfig $config
    ) {
        $this->output = $config->getOutput();
        $this->loop = $config->getLoop();

        $this->initialize();
    }

    private function initialize(): void
    {
        // set up spinner to work automatically
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
        return self::FRAME_INTERVAL;
    }

    public function spin(): void
    {
        // render and output frame
        $this->output->write($this->render());
    }

    private function render(): string
    {
        $moveBackSequence = CSI . '1D';

        $symbol = match ($this->odd) {
            true => '+',
            false => '-',
        };

        $this->odd = !$this->odd;

        return $symbol . $moveBackSequence;
    }
}
