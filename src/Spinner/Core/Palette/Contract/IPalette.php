<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use Traversable;

interface IPalette
{
    /**
     * @return Traversable<IFrame>
     * @deprecated Use {@see IPalette::unwrap()} instead.
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable;

    /**
     * @deprecated
     */
    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions;

    /**
     * TODO (2024-02-15 17:20) [Alec Rabbit]: [790e8e1f-874c-4ac2-90a1-ac9f0ffdb707]
     */
    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate;
}
