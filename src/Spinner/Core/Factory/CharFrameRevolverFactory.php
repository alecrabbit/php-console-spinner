<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Pattern\BakedPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
use AlecRabbit\Spinner\Core\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

final class CharFrameRevolverFactory implements ICharFrameRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected ICharFrameCollectionRenderer $frameCollectionRenderer,
        protected IIntervalFactory $intervalFactory,
    ) {
    }

    public function createCharRevolver(IPattern $charPattern): IFrameRevolver
    {
        $bakedPattern = $this->bakePattern($charPattern);
        return
            $this->frameRevolverBuilder
                ->withFrameCollection($bakedPattern->getFrameCollection())
                ->withInterval($bakedPattern->getInterval())
                ->withTolerance(
                    $this->getTolerance()
                )
                ->build()
        ;
    }

    private function bakePattern(IPattern $pattern): IBakedPattern
    {
        return
            new BakedPattern(
                frames: $this->frameCollectionRenderer->render($pattern),
                interval: $this->intervalFactory->createNormalized($pattern->getInterval()),
            );
    }

    private function getTolerance(): int
    {
        // TODO (2023-04-26 14:21) [Alec Rabbit]: make it configurable [fd86d318-9069-47e2-b60d-a68f537be4a3]
        return IRevolver::TOLERANCE;
    }
}