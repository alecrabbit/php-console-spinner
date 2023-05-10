<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\Contract\ICharFrameFactory;

final class CharFrameFactory implements ICharFrameFactory
{
    public function __construct(
        protected IWidthMeasurer $widthMeasurer,
    ) {
    }

    public function create(string $sequence): IFrame
    {
        return
            new CharFrame(
                $sequence,
                $this->widthMeasurer->measureWidth($sequence)
            );
    }
}
