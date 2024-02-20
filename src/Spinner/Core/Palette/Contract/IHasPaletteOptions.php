<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IHasPaletteOptions
{
    public function getOptions(): IPaletteOptions;
}
