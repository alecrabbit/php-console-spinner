<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IModePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use Traversable;

abstract class AModePalette implements IModePalette
{
    public function __construct(
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        return new PaletteOptions(
            interval: $this->refineInterval($mode),
        );
    }

    protected function refineInterval(?IPaletteMode $mode = null): ?int
    {
        return $this->options->getInterval() ?? $this->modeInterval($mode);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return match ($this->extractStylingMode($mode)) {
            StylingMode::ANSI8 => 1000,
            StylingMode::ANSI24 => 100,
            default => null,
        };
    }

    protected function extractStylingMode(?IPaletteMode $mode): StylingMode
    {
        return $mode?->getStylingMode() ?? StylingMode::NONE;
    }

    /**
     * @return Traversable<ISequenceFrame>
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        /** @var ISequenceFrame|string $item */
        foreach ($this->getFrames($mode) as $item) {
            if ($item instanceof ISequenceFrame) {
                yield $item;
                continue;
            }
            yield $this->createFrame($item);
        }
    }

    /**
     * @return Traversable<IStyleSequenceFrame|string>
     */
    protected function getFrames(?IPaletteMode $mode): Traversable
    {
        $stylingMode = $this->extractStylingMode($mode);

        yield from match ($stylingMode) {
            StylingMode::NONE => $this->noStyleFrames(),
            StylingMode::ANSI4 => $this->ansi4StyleFrames(),
            StylingMode::ANSI8 => $this->ansi8StyleFrames(),
            StylingMode::ANSI24 => $this->ansi24StyleFrames(),
        };
    }

    /**
     * @return Traversable<IStyleSequenceFrame|string>
     */
    protected function noStyleFrames(): Traversable
    {
        yield from [
            $this->createFrame('%s', 0),
        ];
    }

    abstract protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame;

    /**
     * @return Traversable<IStyleSequenceFrame|string>
     */
    protected function ansi4StyleFrames(): Traversable
    {
        return $this->noStyleFrames();
    }

    /**
     * @return Traversable<IStyleSequenceFrame|string>
     */
    protected function ansi8StyleFrames(): Traversable
    {
        return $this->ansi4StyleFrames();
    }

    /**
     * @return Traversable<IStyleSequenceFrame|string>
     */
    protected function ansi24StyleFrames(): Traversable
    {
        return $this->ansi8StyleFrames();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return new StyleSequenceFrame('%s', 0);
    }
}
