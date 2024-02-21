<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Override;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ALegacyPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use RuntimeException;
use Traversable;

final class StyleLegacyPaletteOverride extends ALegacyPalette implements IStylePalette
{
    /** @inheritDoc */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function getFrame(?float $dt = null): IFrame
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected function createFrame(string $element, ?int $width = null): ISequenceFrame
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
