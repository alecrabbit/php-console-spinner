<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;

interface IFrameRevolverBuilder
{
    public function build(): IFrameRevolver;

    public function withFrames(IFrameCollection $frames): IFrameRevolverBuilder;

    public function withInterval(IInterval $interval): IFrameRevolverBuilder;
}
