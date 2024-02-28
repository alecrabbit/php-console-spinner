<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\CharPaletteWrapper;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\CharPattern;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Spinner\Core\UpdateChecker;

final readonly class CharPatternFactory implements ICharPatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private ICharFrameTransformer $transformer,
        private IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IPalette $palette): ICharPattern
    {
        $interval = $this->intervalFactory->createNormalized(
            $palette->getOptions()->getInterval()
        );

        $frames = $this->wrap($palette, $interval);

        return new CharPattern(
            frames: $frames,
            interval: $interval,
        );
    }

    private function wrap(IPalette $palette, IInterval $interval): IHasCharSequenceFrame
    {
        $updateChecker = new UpdateChecker(
            $interval->toMilliseconds(),
            $this->revolverConfig->getTolerance()->toMilliseconds(),
        );

        return new CharPaletteWrapper(
            $palette,
            $this->transformer,
            $updateChecker,
        );
    }
}
