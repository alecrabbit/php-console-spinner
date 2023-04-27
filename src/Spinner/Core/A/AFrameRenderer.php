<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Contract\IFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;

abstract class AFrameRenderer implements IFrameRenderer
{
    public function __construct(
        protected IFrameFactory $frameFactory,
    ) {
    }
}
