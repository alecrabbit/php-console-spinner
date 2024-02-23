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
use AlecRabbit\Spinner\Core\Contract\IUpdateChecker;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePaletteRenderer;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Pattern\StylePattern;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Core\UpdateChecker;

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
        $updateChecker = new UpdateChecker(
            $interval->toMilliseconds(),
            $this->revolverConfig->getTolerance()->toMilliseconds(),
        );

        return new class(
            $palette,
            $this->transformer,
            $updateChecker,
        ) implements IHasStyleSequenceFrame {
            private IFrame $currentFrame;

            public function __construct(
                private readonly IHasFrame $frames,
                private readonly IStyleFrameTransformer $transformer,
                private readonly IUpdateChecker $updateChecker,
            ) {
                $this->currentFrame = $this->getFrame();
            }

            public function getFrame(?float $dt = null): IStyleSequenceFrame
            {
                if ($this->updateChecker->isDue($dt)) {
                    $this->currentFrame = $this->nextFrame($dt);
                }
                return $this->currentFrame;
            }

            private function nextFrame(?float $dt = null): IStyleSequenceFrame
            {
                return $this->transformer->transform(
                    $this->frames->getFrame($dt)
                );
            }
        };
    }
}
