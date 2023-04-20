<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Pattern\NoStylePattern;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;

final class StyleFrameRevolverFactory implements IStyleFrameRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected IStyleFrameCollectionRenderer $styleFrameCollectionRenderer,
        protected IIntervalFactory $intervalFactory,
        protected OptionStyleMode $styleMode,
    ) {
    }

    public function createStyleRevolver(IStylePattern $stylePattern): IFrameRevolver
    {
        if (OptionStyleMode::NONE === $this->styleMode) {
            $stylePattern = new NoStylePattern();
        }
        return
            $this->frameRevolverBuilder
                ->withFrames($this->getFrameCollection($stylePattern))
                ->withInterval(
                    $this->intervalFactory->createNormalized(
                        $stylePattern->getInterval()
                    )
                )
                ->build()
        ;
    }

    private function getFrameCollection(IPattern $stylePattern): IFrameCollection
    {
        return $this->styleFrameCollectionRenderer->render($stylePattern);
    }
}
