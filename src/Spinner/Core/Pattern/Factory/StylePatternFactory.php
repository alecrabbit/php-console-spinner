<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IStylePattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePaletteRenderer;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Pattern\StylePattern;

final readonly class StylePatternFactory implements IStylePatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private IStyleFrameTransformer $transformer,
        private IModePaletteRenderer $paletteRenderer,
        private IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IPalette $palette): IStylePattern
    {
        if ($palette instanceof IModePalette) {
            $palette = $this->paletteRenderer->render($palette);
        }

        $interval = $this->intervalFactory->createNormalized(
            $palette->getOptions()->getInterval()
        );

        $frames = $this->wrap($palette, $interval);

        return new StylePattern(
            frames: $frames,
            interval: $interval,
        );
    }
    private function wrap(IPalette $palette, IInterval $interval): IHasStyleSequenceFrame
    {
        return new class(
            $palette,
            $this->transformer,
            $interval,
            $this->revolverConfig->getTolerance(),
        ) implements IHasStyleSequenceFrame {
            private readonly int $toleranceValue;
            private readonly float $intervalValue;
            private float $diff;
            private IFrame $currentFrame;

            public function __construct(
                private readonly IHasFrame $frames,
                private readonly IStyleFrameTransformer $transformer,
                IInterval $interval,
                private readonly ITolerance $tolerance,
            ) {
                $this->toleranceValue = $this->tolerance->toMilliseconds();
                $this->intervalValue = $interval->toMilliseconds();
                $this->diff = $this->intervalValue;
            }

            public function getFrame(?float $dt = null): IStyleSequenceFrame
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
