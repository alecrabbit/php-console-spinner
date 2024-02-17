<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Override;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use RuntimeException;
use Traversable;

final class StylePaletteOverride extends APalette implements IStylePalette
{
    /** @inheritDoc */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    /**
     * TODO (2024-02-15 17:20) [Alec Rabbit]: [790e8e1f-874c-4ac2-90a1-ac9f0ffdb707]
     */
    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected function createFrame(string $element, ?int $width = null): ISequenceFrame
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
