<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\ITemplate;

final class PaletteTemplate implements ITemplate
{
    public function __construct(
        protected \Traversable $entries,
        protected ?int $interval = null,
    ) {
    }

    public function getEntries(): \Traversable
    {
        return $this->entries;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }
}
