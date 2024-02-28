<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use ArrayObject;

final class Snake extends ACharPalette
{
    public function __construct(
        IPaletteOptions $options = new PaletteOptions(interval: 80),
        int $index = 0,
    ) {
        parent::__construct(
            new ArrayObject(
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
            ),
            $options,
            $index
        );
    }
}
