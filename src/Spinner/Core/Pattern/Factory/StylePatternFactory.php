<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Pattern\NeoStylePattern;

final readonly class StylePatternFactory implements IStylePatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private IStyleFrameTransformer $transformer,
    ) {
    }

    public function create(IPalette $palette): INeoStylePattern
    {
//        if ($palette instanceof IPalette) {
//            // FIXME (2024-02-20 16:31) [Alec Rabbit]:STUB! [343d6cb2-4ca9-41de-9436-2b10154e6c95] Remove this
//            $palette = new NoStyleNeoPalette();
//        }

        return new NeoStylePattern(
            frames: $palette,
            interval: $this->createInterval($palette->getOptions()->getInterval()),
            transformer: $this->transformer,
        );
    }

    private function createInterval(?int $interval): IInterval
    {
        return $this->intervalFactory->createNormalized($interval);
    }


}
