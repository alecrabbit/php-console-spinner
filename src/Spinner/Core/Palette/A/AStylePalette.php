<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use Traversable;

abstract class AStylePalette extends APalette implements IStylePalette
{
    /**
     * @return Traversable<IStyleFrame>
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        /** @var IStyleFrame|string $item */
        foreach ($this->getFrames($mode) as $item) {
            if ($item instanceof IStyleFrame) {
                yield $item;
                continue;
            }
            yield $this->createFrame($item);
        }
    }

    /**
     * @return Traversable<IStyleFrame|string>
     */
    protected function getFrames(?IPaletteMode $mode): Traversable
    {
        $stylingMode = $this->extractStylingMode($mode);

        yield from match ($stylingMode) {
            StylingMethodMode::NONE => $this->noStyleFrames(),
            StylingMethodMode::ANSI4 => $this->ansi4StyleFrames(),
            StylingMethodMode::ANSI8 => $this->ansi8StyleFrames(),
            StylingMethodMode::ANSI24 => $this->ansi24StyleFrames(),
        };
    }

    /**
     * @return Traversable<IStyleFrame|string>
     */
    protected function noStyleFrames(): Traversable
    {
        yield from [
            $this->createFrame('%s'),
        ];
    }

    abstract protected function createFrame(string $element, ?int $width = null): IStyleFrame;

    /**
     * @return Traversable<IStyleFrame|string>
     */
    protected function ansi4StyleFrames(): Traversable
    {
        return $this->noStyleFrames();
    }

    /**
     * @return Traversable<IStyleFrame|string>
     */
    protected function ansi8StyleFrames(): Traversable
    {
        return $this->ansi4StyleFrames();
    }

    /**
     * @return Traversable<IStyleFrame|string>
     */
    protected function ansi24StyleFrames(): Traversable
    {
        return $this->ansi8StyleFrames();
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return match ($this->extractStylingMode($mode)) {
            StylingMethodMode::ANSI8 => 1000,
            StylingMethodMode::ANSI24 => 100,
            default => null,
        };
    }
}
