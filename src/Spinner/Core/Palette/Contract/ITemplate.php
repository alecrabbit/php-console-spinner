<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface  ITemplate
{
    public function getEntries(): \Traversable;

    /** @deprecated */
    public function getInterval(): ?int;

    public function getOptions(): IPaletteOptions;
}
