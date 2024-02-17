<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override;

use AlecRabbit\Spinner\Core\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\StyleFrame;
use RuntimeException;
use Traversable;

final class AStylePaletteOverride extends AStylePalette
{
    public function __construct(
        IPaletteOptions $options,
        protected ?Traversable $entries = null,
    ) {
        parent::__construct($options);
    }

    /**
     * TODO (2024-02-15 17:20) [Alec Rabbit]: [790e8e1f-874c-4ac2-90a1-ac9f0ffdb707]
     */
    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected function noStyleFrames(): Traversable
    {
        yield from $this->entries;
    }

    protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }
}
