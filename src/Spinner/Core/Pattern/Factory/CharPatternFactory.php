<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\Pattern\INeoCharPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\INeoPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\NeoCharPattern;

final readonly class CharPatternFactory implements ICharPatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private ICharFrameTransformer $transformer,
    ) {
    }

    public function create(INeoPalette|IPalette $palette): INeoCharPattern
    {
        return new NeoCharPattern(
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
