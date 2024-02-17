<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use Traversable;

interface IPaletteTemplate
{
    /**
     * @return IHasFrame|Traversable<ISequenceFrame>
     */
    public function getEntries(): IHasFrame|Traversable;

    public function getOptions(): IPaletteOptions;
}
