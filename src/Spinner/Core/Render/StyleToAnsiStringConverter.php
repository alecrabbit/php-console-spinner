<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;

final class StyleToAnsiStringConverter implements IStyleToAnsiStringConverter
{
    public function __construct(
        protected OptionStyleMode $styleMode,
        protected ISequencer $sequencer,
    ) {
    }

    public function convert(IStyle $style): string
    {
        if ($this->styleMode === OptionStyleMode::NONE || $style->isEmpty()) {
            return $style->getFormat();
        }

        return '';
//        return
//            dump(
//                $this->sequencer->colorSequence(
//                    '3' .
//                    $this->converter->ansiCode($style->getFgColor(), $this->styleMode) . 'm' .
//                    $style->getFormat()
//                )
//            );
//
    }
}
