<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use Traversable;

interface IPaletteTemplate
{
    /**
     * @return Traversable<ISequenceFrame>
     */
    public function getEntries(): Traversable;

    public function getOptions(): IPaletteOptions;
}
