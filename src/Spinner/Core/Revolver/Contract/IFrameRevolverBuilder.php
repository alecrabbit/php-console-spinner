<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;

interface IFrameRevolverBuilder
{
    public function build(): IFrameRevolver;

    public function withFrameCollection(IFrameCollection $frames): IFrameRevolverBuilder;

    public function withInterval(IInterval $interval): IFrameRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): IFrameRevolverBuilder;
}
