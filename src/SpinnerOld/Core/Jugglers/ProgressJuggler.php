<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Core\Coloring\Style;
use AlecRabbit\Spinner\Settings\Settings;

use function AlecRabbit\Helpers\bounds;

class ProgressJuggler extends AbstractJuggler
{
    /** @var string */
    protected $currentFrame;

    public function __construct(Settings $settings, Style $style)
    {
        $this->init($style);
        $this->update($settings->getInitialPercent());
    }

    /**
     * @param null|float $percent
     */
    protected function update(?float $percent): void
    {
        $progress = bounds($percent ?? 0.0, 0, 1);
        $this->currentFrame = (int)($progress * 100) . '%';
        $this->currentFrameErasingWidth =
            mb_strwidth($this->currentFrame . $this->spacer) + $this->formatErasingWidthShift;
    }

    /**
     * @param float $percent
     */
    public function setProgress(float $percent): void
    {
        $this->update($percent);
    }

    /** {@inheritDoc} */
    protected function getCurrentFrame(): string
    {
        return $this->currentFrame;
    }
}
