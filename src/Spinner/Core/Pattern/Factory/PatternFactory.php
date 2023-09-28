<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Pattern;

final class PatternFactory implements IPatternFactory
{
    public function __construct(
        protected IIntervalFactory $intervalFactory,
        protected IPaletteModeFactory $paletteModeFactory,
    ) {
    }

    public function create(IPalette $palette): IPattern
    {
        $entries = $palette->getEntries($this->createPaletteMode());

        return
            new Pattern(
                interval: $this->createInterval($palette),
                frames: $entries,
            );
    }

    private function createPaletteMode(): IPaletteMode
    {
        return
            $this->paletteModeFactory->create();
    }

    private function createInterval(IPalette $palette): IInterval
    {
        return
            $this->intervalFactory->createNormalized(
                dump($palette->getOptions()->getInterval())
            );
    }
}
