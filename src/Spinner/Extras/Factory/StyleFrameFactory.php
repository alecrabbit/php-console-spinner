<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameFactory;

final class StyleFrameFactory implements IStyleFrameFactory
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
                $width ?? $this->measure($sequence)
            );
    }

    protected function measure(string $sequence): int
    {
        return
            $this->widthMeasurer->measureWidth(
                $this->refineSequence($sequence)
            );
    }

    protected function refineSequence(string $sequence): string|array
    {
        return str_replace('%s', '', $sequence);
    }
}
