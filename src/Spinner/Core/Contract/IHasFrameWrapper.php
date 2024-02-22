<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasFrame;

interface IHasFrameWrapper
{
    public function wrap(IHasFrame $frames): IHasFrame;
}
