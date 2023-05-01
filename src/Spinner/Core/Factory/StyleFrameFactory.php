<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\StyleFrame;

final class StyleFrameFactory implements Contract\IStyleFrameFactory
{
    public function __construct(
        protected IWidthMeasurer $widthMeasurer,
    ) {
    }
    public function create(string $sequence, ?int $width = null): IFrame
    {
        return
            new StyleFrame(
                $sequence,
                $width ?? $this->widthMeasurer->getWidth($sequence)
            );
    }
}
