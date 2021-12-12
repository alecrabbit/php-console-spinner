<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;

use AlecRabbit\Spinner\Core\Driver;

use const AlecRabbit\Cli\CSI;

final class Spinner implements ISpinner
{
    private const FRAME_INTERVAL = 0.1;
    private bool $odd = true;
    private bool $async;
    private Driver $driver;
    private Core\Color $colors;
    private Core\Frame $frames;

    public function __construct(
        private ISpinnerConfig $config
    ) {
        $this->async = $this->config->isAsync();
        $this->driver = new Driver($config->getOutput());
        $this->colors = $this->config->getColors();
        $this->frames = $this->config->getFrames();
    }

    public function interval(): int|float
    {
        return self::FRAME_INTERVAL;
    }

    public function spin(): void
    {
        // render and output frame
        $this->driver->write($this->render());
    }

    private function render(): string
    {
        $moveBackSequence = CSI . '1D';

        return $this->driver->frameSequence( $this->colors->next(),  $this->frames->next()) . $moveBackSequence;
    }

    public function isAsync(): bool
    {
        return $this->async;
    }
}
