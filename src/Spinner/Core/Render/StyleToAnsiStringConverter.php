<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;

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

        return
            $this->sequencer->colorSequence(
                '3' .
                $this->converter->ansiCode($style->getFgColor()) . 'm' .
                $style->getFormat()
            );
    }
}
