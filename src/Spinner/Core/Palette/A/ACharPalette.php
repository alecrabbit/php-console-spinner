<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

abstract class ACharPalette extends APalette implements ICharPalette
{
    /**
     * @return Traversable<ICharSequenceFrame>
     * @deprecated
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        /** @var string|ICharSequenceFrame $element */
        foreach ($this->sequence() as $element) {
            if ($element instanceof ICharSequenceFrame) {
                yield $element;
                continue;
            }
            yield $this->createFrame($element);
        }
    }

    /**
     * @return Traversable<string|ICharSequenceFrame>
     */
    abstract protected function sequence(): Traversable;

    abstract protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame;

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 200;
    }
}
