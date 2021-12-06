<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Core\Jugglers;

use AlecRabbit\SpinnerOld\Core\Circular;
use AlecRabbit\SpinnerOld\Core\Calculator;
use AlecRabbit\SpinnerOld\Core\Coloring\Style;
use AlecRabbit\SpinnerOld\Core\Sentinel;
use AlecRabbit\SpinnerOld\Settings\Settings;

class FrameJuggler extends AbstractJuggler
{
    /** @var Circular */
    protected $frames;

    public function __construct(Settings $settings, Style $style)
    {
        $frames = $settings->getFrames();
        Sentinel::assertFrames($frames);
        $this->frames = new Circular($frames);
        $this->init($style);
        $this->currentFrameErasingWidth =
            Calculator::computeErasingWidths($frames) + mb_strwidth($this->spacer) + $this->formatErasingWidthShift;
    }

    /**
     * @return string
     */
    protected function getCurrentFrame(): string
    {
        return $this->frames->value();
    }
}
