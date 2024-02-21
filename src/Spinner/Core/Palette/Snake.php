<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use ArrayObject;
use Traversable;

final class Snake implements ICharPalette
{
    /** @var ArrayObject<int, ISequenceFrame> */
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
        $this->next();
        return $this->frames->offsetGet($this->index);
    }

    private function next(): void
    {
        if ($this->count === 1 || ++$this->index === $this->count) {
            $this->index = 0;
        }
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
