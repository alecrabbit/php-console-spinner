<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use Traversable;

interface  IPaletteTemplate
{
    public function getEntries(): Traversable;

    public function getOptions(): IPaletteOptions;
}