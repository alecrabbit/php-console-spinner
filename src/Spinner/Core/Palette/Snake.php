<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use ArrayObject;

final class Snake implements ICharPalette
{
    /** @var ArrayObject<int, ICharSequenceFrame> */
    private ArrayObject $frames;
    private int $count;

    public function __construct(
        private readonly IPaletteOptions $options = new PaletteOptions(interval: 80),
        private int $index = 0,
    ) {
        $this->frames = new ArrayObject(
            [
                new CharSequenceFrame('⠏', 1),
                new CharSequenceFrame('⠛', 1),
                new CharSequenceFrame('⠹', 1),
                new CharSequenceFrame('⢸', 1),
                new CharSequenceFrame('⣰', 1),
                new CharSequenceFrame('⣤', 1),
                new CharSequenceFrame('⣆', 1),
                new CharSequenceFrame('⡇', 1),
            ],
        );
        $this->count = $this->frames->count();
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
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
