<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use Traversable;

class APaletteOverride extends APalette
{
    public function __construct(
        IPaletteOptions $options,
        protected ?Traversable $entries = null,
    ) {
        parent::__construct($options);
    }

    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        return $this->entries;
    }
}
