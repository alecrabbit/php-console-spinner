<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Coloring\Style;
use AlecRabbit\Spinner\Core\Sentinel;
use AlecRabbit\Spinner\Settings\Settings;

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
        $this->currentFrameErasingLength =
            Calculator::computeErasingLength($frames) + mb_strwidth($this->spacer) + $this->formatErasingShift;
    }

    /**
     * @return string
     */
    protected function getCurrentFrame(): string
    {
        return $this->frames->value();
    }
}
