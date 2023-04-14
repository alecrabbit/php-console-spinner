<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use function count;

final class StyleToAnsiStringConverter implements IStyleToAnsiStringConverter
{
    public function __construct(
        protected IHexColorToAnsiCodeConverter $converter,
        protected ISequencer $sequencer,
    ) {
    }

    public function convert(IStyle $style): string
    {
        if ($style->isEmpty()) {
            return $style->getFormat();
        }

        $fg = $this->parse((string)$style->getFgColor());
        $bg = $this->parse((string)$style->getBgColor(), true);

        return
            $this->set($fg, $bg) . $style->getFormat() . $this->unset($fg, $bg);
        //        return
//            $this->sequencer->colorSequence(
//                '3' .
//                $this->converter->ansiCode($style->getFgColor()) . 'm' .
//                $style->getFormat()
//            );
    }

    protected function parse(string $color, bool $bg = false): string
    {
        if ('' === $color) {
            return '';
        }

        if ('#' === $color[0]) {
            return ($bg ? '4' : '3') . $this->converter->ansiCode($color);
        }

        throw new InvalidArgumentException('Invalid color format: ' . $color);
    }

    protected function set(string $fg, string $bg): string
    {
        $setCodes = [];
        if ('' !== $fg) {
            $setCodes[] = $fg;
        }
        if ('' !== $bg) {
            $setCodes[] = $bg;
        }
        if (0 === count($setCodes)) {
            return '';
        }

        return sprintf("\033[%sm", implode(';', $setCodes));
    }

    public function unset(string $fg, string $bg): string
    {
        $unsetCodes = [];
        if ('' !== $fg) {
            $unsetCodes[] = 39;
        }
        if ('' !== $bg) {
            $unsetCodes[] = 49;
        }
        if (0 === count($unsetCodes)) {
            return '';
        }

        return sprintf("\033[%sm", implode(';', $unsetCodes));
    }
}
