<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use Traversable;

class ACharPaletteOverride extends ACharPalette
{
    public function __construct(
        IPaletteOptions $options,
        protected ?Traversable $entries = null,
    ) {
        parent::__construct($options);
    }

    protected function sequence(): Traversable
    {
        foreach ($this->entries as $element) {
            yield $this->createFrame($element);
        }
    }

    protected function createFrame(string $element): ICharFrame
    {
        return new CharFrame($element, 1);
    }
}
