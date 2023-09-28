<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use Traversable;

interface IPalette
{
    public function getTemplate(?IPaletteMode $mode = null): ITemplate;
}
