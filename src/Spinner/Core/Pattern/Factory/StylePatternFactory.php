<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\INeoPalette;
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

    public function create(INeoPalette|IPalette $palette): INeoStylePattern
    {
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