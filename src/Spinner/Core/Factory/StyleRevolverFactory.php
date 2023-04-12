<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class StyleRevolverFactory implements IStyleRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
    ) {
    }


    public function createStyleRevolver(): IFrameRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrames()
                ->withInterval()
                ->build();
    }
}
