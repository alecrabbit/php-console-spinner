<?php

declare(strict_types=1);

// 04.04.23

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;

abstract class AFrameRenderer implements IFrameRenderer
{
    public function __construct(
        protected IFrameFactory $frameFactory,
    ) {
    }
}
