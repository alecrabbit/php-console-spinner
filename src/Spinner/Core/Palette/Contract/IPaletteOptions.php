<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface IPaletteOptions
{
    public function isReversed(): bool;

    public function getInterval(): ?int;
}
