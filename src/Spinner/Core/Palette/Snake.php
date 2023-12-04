<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use Traversable;

use function array_reverse;

final class Snake extends ACharPalette
{
    protected function sequence(): Traversable
    {
        yield from ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    }

    protected function createFrame(string $element): ICharFrame
    {
        return new CharFrame($element, 1);
    }

    protected function getInterval(): ?int
    {
        return 80;
    }
}
