<?php

declare(strict_types=1);

// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class CharRevolverFactory implements ICharRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected ICharFrameCollectionRenderer $charFrameCollectionRenderer,
    ) {
    }


    public function createCharRevolver(IPattern $charPattern): IFrameRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrames($this->getFrameCollection($charPattern))
                ->withInterval($charPattern->getInterval())
                ->build()
        ;
    }

    protected function getFrameCollection(IPattern $charPattern): IFrameCollection
    {
        return $this->charFrameCollectionRenderer->render($charPattern);
    }
}
