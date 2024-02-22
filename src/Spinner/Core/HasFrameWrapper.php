<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Core\Contract\IHasFrameWrapper;

final readonly class HasFrameWrapper implements IHasFrameWrapper
{

    public function wrap(IHasFrame $frames): IHasFrame
    {
        return $frames;
    }
}
