<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use RuntimeException;
use Traversable;

/**
 * @deprecated
 */
final class LegacyNoStylePalette extends APalette implements IStylePalette
{
    /**
     * TODO (2024-02-15 17:20) [Alec Rabbit]: [790e8e1f-874c-4ac2-90a1-ac9f0ffdb707]
     */
    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        // TODO: Implement unwrap() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    /** @inheritDoc */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        yield from [
            $this->createFrame('%s')
        ];
    }
    public function getFrame(?float $dt = null): IFrame
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
    protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame
    {
        return new StyleSequenceFrame($element, $width ?? 0);
    }
}
