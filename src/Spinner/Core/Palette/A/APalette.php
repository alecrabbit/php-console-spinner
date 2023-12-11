<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use Traversable;

abstract class APalette implements IPalette
{
    public function __construct(
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    /** @inheritDoc */
    abstract public function getEntries(?IPaletteMode $mode = null): Traversable;

    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        return new PaletteOptions(
            interval: $this->refineInterval($mode),
            reversed: $this->options->isReversed(),
        );
    }

    protected function refineInterval(?IPaletteMode $mode = null): ?int
    {
        return $this->options->getInterval() ?? $this->modeInterval($mode);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return null;
    }

    abstract protected function createFrame(string $element, ?int $width = null): IFrame;

    protected function extractStylingMode(?IPaletteMode $mode): StylingMethodMode
    {
        return $mode?->getStylingMode() ?? StylingMethodMode::NONE;
    }
}
