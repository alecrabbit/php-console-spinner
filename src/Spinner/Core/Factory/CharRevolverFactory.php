<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class CharRevolverFactory implements ICharRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
    ) {
    }


    public function createCharRevolver(): IFrameRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrames()
                ->withInterval()
                ->build();
    }
}
