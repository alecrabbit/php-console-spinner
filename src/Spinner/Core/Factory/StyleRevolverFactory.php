<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class StyleRevolverFactory implements IStyleRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected IStyleFrameCollectionRenderer $styleFrameCollectionRenderer,
    ) {
    }


    public function createStyleRevolver(IPattern $stylePattern): IFrameRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrames($this->getFrameCollection($stylePattern))
                ->withInterval($stylePattern->getInterval())
                ->build();
    }

    protected function getFrameCollection(IPattern $stylePattern): IFrameCollection
    {
        return $this->styleFrameCollectionRenderer->pattern($stylePattern)->render();
    }
}
