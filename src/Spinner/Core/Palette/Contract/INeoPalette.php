<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use Traversable;

interface INeoPalette
{
    public function getOptions(): IPaletteOptions;
}
