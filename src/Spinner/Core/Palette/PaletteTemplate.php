<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use Traversable;

final class PaletteTemplate implements IPaletteTemplate
{
    public function __construct(
        protected Traversable $entries,
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    public function getEntries(): Traversable
    {
        return $this->entries;
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
