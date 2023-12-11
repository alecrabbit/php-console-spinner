<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

abstract class ACharPalette extends APalette implements ICharPalette
{
    /**
     * @return Traversable<ICharFrame>
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        /** @var string|ICharFrame $element */
        foreach ($this->sequence() as $element) {
            if ($element instanceof ICharFrame) {
                yield $element;
                continue;
            }
            yield $this->createFrame($element);
        }
    }

    /**
     * @return Traversable<string|ICharFrame>
     */
    abstract protected function sequence(): Traversable;

    abstract protected function createFrame(string $element, ?int $width = null): ICharFrame;

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 200;
    }
}
