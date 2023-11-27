<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use Traversable;

interface IPaletteTemplate
{
    /**
     * @return Traversable<IFrame>
     */
    public function getEntries(): Traversable;

    public function getOptions(): IPaletteOptions;
}
