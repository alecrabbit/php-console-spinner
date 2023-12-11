<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

abstract class AStylePalette extends APalette implements IStylePalette
{
    public function getOptions(?IPaletteMode $mode = null): IPaletteOptions
    {
        $interval = $this->options->getInterval() ?? $this->getInterval($this->extractStylingMode($mode));

        $this->options =
            new PaletteOptions(
                interval: $interval,
                reversed: $this->options->isReversed(),
            );

        return parent::getOptions($mode);
    }

    protected function getInterval(StylingMethodMode $stylingMode): ?int
    {
        return match ($stylingMode) {
            StylingMethodMode::ANSI8 => 1000,
            StylingMethodMode::ANSI24 => 100,
            default => null,
        };
    }

    protected function extractStylingMode(?IPaletteMode $options): StylingMethodMode
    {
        return $options?->getStylingMode() ?? StylingMethodMode::NONE;
    }

    /**
     * @return Traversable<IStyleFrame>
     */
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        $stylingMode = $this->extractStylingMode($mode);


        $frames = match ($stylingMode) {
            StylingMethodMode::NONE => $this->noStyleFrames(),
            StylingMethodMode::ANSI4 => $this->ansi4StyleFrames(),
            StylingMethodMode::ANSI8 => $this->ansi8StyleFrames(),
            StylingMethodMode::ANSI24 => $this->ansi24StyleFrames(),
        };

        /** @var IStyleFrame|string $item */
        foreach ($frames as $item) {
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
    protected function noStyleFrames(): Traversable
    {
        yield from [
            $this->createFrame('%s'),
        ];
    }

    protected function createFrame(string $element): IStyleFrame
    {
        return new StyleFrame($element, 0);
    }

    /**
     * @return Traversable<IStyleFrame|string>
     */
    abstract protected function ansi4StyleFrames(): Traversable;

    /**
     * @return Traversable<IStyleFrame|string>
     */
    abstract protected function ansi8StyleFrames(): Traversable;

    /**
     * @return Traversable<IStyleFrame|string>
     */
    abstract protected function ansi24StyleFrames(): Traversable;
}
