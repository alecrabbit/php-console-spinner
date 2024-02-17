<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use RuntimeException;
use Traversable;

final class Snake extends ACharPalette
{
    /**
     * TODO (2024-02-15 17:20) [Alec Rabbit]: [790e8e1f-874c-4ac2-90a1-ac9f0ffdb707]
     */
    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        // TODO: Implement unwrap() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    protected function sequence(): Traversable
    {
        yield from ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    }

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharFrame($element, $width ?? 1);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 80;
    }
}
