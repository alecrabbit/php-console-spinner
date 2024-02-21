<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\AStyleLegacyPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use RuntimeException;
use Traversable;

final class AStylePaletteOverride extends AStyleLegacyPalette
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

    protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame
    {
        return new StyleSequenceFrame($element, $width ?? 0);
    }
}
