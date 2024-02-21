<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;

abstract class AStylePalette implements IStylePalette
{
    private int $count;

    public function __construct(
        private readonly \ArrayObject $frames,
        private readonly IPaletteOptions $options,
        private int $index = 0,
    ) {
        $this->count = $this->frames->count();
    }

    public function getFrame(?float $dt = null): IStyleSequenceFrame
    {
        if ($this->count === 1 || ++$this->index === $this->count) {
            $this->index = 0;
        }

        return $this->frames->offsetGet($this->index);
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
