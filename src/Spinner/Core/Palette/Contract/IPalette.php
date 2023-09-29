<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IPalette
{
    public function getTemplate(?IPaletteMode $mode = null): ITemplate;
}
