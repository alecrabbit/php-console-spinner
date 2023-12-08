<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;

final readonly class PaletteOptions implements IPaletteOptions
{
    public function __construct(
        protected ?int $interval = null,
        protected bool $reversed = false,
    ) {
    }

    public function isReversed(): bool
    {
        return $this->reversed;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }
}
