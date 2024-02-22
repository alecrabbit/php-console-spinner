<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IHasFrameWrapper;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
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
        return new class(
            $palette,
            $this->transformer,
            $interval,
            $this->revolverConfig->getTolerance(),
        ) implements IHasCharSequenceFrame {
            private readonly int $toleranceValue;
            private readonly float $intervalValue;
            private float $diff;
            private IFrame $currentFrame;

            public function __construct(
                private readonly IHasFrame $frames,
                private readonly ICharFrameTransformer $transformer,
                IInterval $interval,
                private readonly ITolerance $tolerance,
            ) {
                $this->toleranceValue = $this->tolerance->toMilliseconds();
                $this->intervalValue = $interval->toMilliseconds();
                $this->diff = $this->intervalValue;
                $this->currentFrame = $this->getFrame();
            }

            public function getFrame(?float $dt = null): ICharSequenceFrame
            {
                if ($this->shouldUpdate($dt)) {
                    $this->currentFrame = $this->transformer->transform(
                        $this->frames->getFrame($dt)
                    );
                }
                return $this->currentFrame;
            }

            private function shouldUpdate(?float $dt = null): bool
            {
                if ($dt === null || $this->intervalValue <= ($dt + $this->toleranceValue) || $this->diff <= 0) {
                    $this->diff = $this->intervalValue;
                    return true;
                }
                $this->diff -= $dt;
                return false;
            }
        };
    }
}
