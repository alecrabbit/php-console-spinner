<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\Contract\IHasFrameWrapper;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\CharPattern;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;

final readonly class CharPatternFactory implements ICharPatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private ICharFrameTransformer $transformer,
        private IHasFrameWrapper $wrapper,
    ) {
    }

    public function create(IPalette $palette): ICharPattern
    {
        $interval = $this->intervalFactory->createNormalized(
            $palette->getOptions()->getInterval()
        );

        $frames = $this->wrapper->wrap($palette);

        return new CharPattern(
            frames: $frames,
            interval: $interval,
            transformer: $this->transformer,
        );
    }
}
