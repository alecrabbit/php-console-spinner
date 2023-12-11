<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

final class Snake extends ACharPalette
{
    protected function sequence(): Traversable
    {
        yield from ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 1);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 80;
    }
}
