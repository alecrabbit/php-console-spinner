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
    /** @inheritDoc */
    protected function sequence(): Traversable
    {
        $a = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];

        if ($this->options->getReversed()) {
            $a = array_reverse($a);
        }

        yield from $a;
    }


    protected function createFrame(string $element): ICharFrame
    {
        return new CharFrame($element, 1);
    }
}
