<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;

use Traversable;

use function array_reverse;

final class Snake extends APalette implements ICharPalette
{
    public function getEntries(?IPaletteMode $entriesMode = null): Traversable
    {
        $this->options =
            new PaletteOptions(
                interval: $this->options->getInterval() ?? 80,
                reversed: $this->options->getReversed(),
            );

        /** @var string $element */
        foreach ($this->sequence() as $element) {
            yield new CharFrame($element, 1);
        }
    }

    private function sequence(): Traversable
    {
        $a = [
            '⠏',
            '⠛',
            '⠹',
            '⢸',
            '⣰',
            '⣤',
            '⣆',
            '⡇',
        ];

        if ($this->options->getReversed()) {
            $a = array_reverse($a);
        }

        yield from $a;
    }
}
