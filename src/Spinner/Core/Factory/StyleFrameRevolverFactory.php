<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Legacy\BakedPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ILegacyBakedPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\NoStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;

final class StyleFrameRevolverFactory implements IStyleFrameRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected IFrameCollectionFactory $frameCollectionFactory,
        protected IIntervalFactory $intervalFactory,
        protected StylingMethodOption $styleMode,
    ) {
    }

    public function createStyleRevolver(IStyleLegacyPattern $stylePattern): IFrameRevolver
    {
        $bakedPattern = $this->bakePattern($stylePattern);
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
        if (StylingMethodOption::NONE === $this->styleMode) {
            $pattern = new NoStylePattern();
        }
        return
            new BakedPattern(
                frames: $this->frameCollectionFactory->create($pattern->getEntries($this->styleMode)),
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
