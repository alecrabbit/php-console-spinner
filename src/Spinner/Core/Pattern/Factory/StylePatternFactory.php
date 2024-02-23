<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\Pattern\IStylePattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePaletteRenderer;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\StylePaletteWrapper;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Pattern\StylePattern;
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

        return new StylePaletteWrapper(
            $palette,
            $this->transformer,
            $updateChecker,
        );
    }
}
