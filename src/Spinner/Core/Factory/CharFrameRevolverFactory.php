<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Pattern\Legacy\BakedPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ILegacyBakedPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;

final class CharFrameRevolverFactory implements ICharFrameRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected IFrameCollectionFactory $frameCollectionFactory,
        protected IIntervalFactory $intervalFactory,
    ) {
    }

    public function createCharRevolver(ILegacyPattern $charPattern): IFrameRevolver
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

    private function bakePattern(ILegacyPattern $pattern): ILegacyBakedPattern
    {
        return
            new BakedPattern(
                frames: $this->frameCollectionFactory->create($pattern->getEntries()),
                interval: $this->intervalFactory->createNormalized($pattern->getInterval()),
            );
    }

    public function create(IPattern $pattern): IFrameRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrameCollection(
                    $this->frameCollectionFactory->create(
                        $pattern->getFrames()
                    )
                )
                ->withInterval(
                    $pattern->getInterval()
                )
                ->withTolerance(
                    $this->getTolerance()
                )
                ->build()
        ;
    }

    private function getTolerance(): ITolerance
    {
        // TODO (2023-04-26 14:21) [Alec Rabbit]: make it configurable [fd86d318-9069-47e2-b60d-a68f537be4a3]
        return new Tolerance();
    }
}
