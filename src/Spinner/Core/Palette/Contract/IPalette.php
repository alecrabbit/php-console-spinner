<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use Traversable;

interface IPalette
{
    /**
     * @return Traversable<IFrame>
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable;

    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions;
}
