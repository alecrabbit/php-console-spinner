<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use Traversable;

abstract class ACharPalette extends APalette implements ICharPalette
{
    /**
     * @return Traversable<ICharFrame>
     */
    protected function getEntries(?IPaletteMode $mode = null): Traversable
    {
        /** @var string $element */
        foreach ($this->sequence() as $element) {
            yield $this->createFrame($element);
        }
    }

    /**
     * @return Traversable<string>
     */
    abstract protected function sequence(): Traversable;

    abstract protected function createFrame(string $element): ICharFrame;

    protected function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        $this->options =
            new PaletteOptions(
                interval: $this->options->getInterval() ?? 80,
                reversed: $this->options->getReversed(),
            );

        return parent::getOptions($mode);
    }
}
