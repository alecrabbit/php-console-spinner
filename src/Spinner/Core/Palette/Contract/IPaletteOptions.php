<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IPaletteOptions
{
    /**
     * @deprecated Palette will NOT have reversed option.
     */
    public function isReversed(): bool;

    public function getInterval(): ?int;
}
