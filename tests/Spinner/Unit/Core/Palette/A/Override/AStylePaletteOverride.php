<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

final class AStylePaletteOverride extends AStylePalette
{
    public function __construct(
        IPaletteOptions $options,
        protected ?Traversable $entries = null,
    ) {
        parent::__construct($options);
    }

    protected function noStyleFrames(): Traversable
    {
        yield from $this->entries;
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }
}
