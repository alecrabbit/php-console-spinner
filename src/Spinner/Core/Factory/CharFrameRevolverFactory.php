<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class CharFrameRevolverFactory implements ICharFrameRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected ICharFrameCollectionRenderer $charFrameCollectionRenderer,
        protected IIntervalFactory $intervalFactory,
    ) {
    }

    public function createCharRevolver(IPattern $charPattern): IFrameRevolver
    {
        return $this->frameRevolverBuilder
            ->withFrames($this->getFrameCollection($charPattern))
            ->withInterval(
                $this->intervalFactory->createNormalized(
                    (int)$charPattern->getInterval()->toMilliseconds()
                )
            )
            ->build()
        ;
    }

    private function getFrameCollection(IPattern $charPattern): IFrameCollection
    {
        return $this->charFrameCollectionRenderer->render($charPattern);
    }
}
