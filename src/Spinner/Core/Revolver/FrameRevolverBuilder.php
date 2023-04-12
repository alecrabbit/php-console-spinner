<?php
declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class FrameRevolverBuilder implements IFrameRevolverBuilder
{

    public function build(): IFrameRevolver
    {
        // TODO: Implement build() method.
    }

    public function withFrames(IFrameCollection $frames): IFrameRevolverBuilder
    {
        // TODO: Implement withFrames() method.
    }

    public function withInterval(IInterval $interval): IFrameRevolverBuilder
    {
        // TODO: Implement withInterval() method.
    }
}
