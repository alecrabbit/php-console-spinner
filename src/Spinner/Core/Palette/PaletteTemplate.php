<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\ITemplate;
use Traversable;

final class PaletteTemplate implements ITemplate
{
    public function __construct(
        protected Traversable $entries,
        protected ?int $interval = null,
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    public function getEntries(): Traversable
    {
        return $this->entries;
    }

    /** @inheritDoc */
    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
