<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IModePaletteRenderer
{
    public function render(IModePalette $palette): IPalette;
}
