<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Spinner\Core\Sequencer;

abstract class AStyleFrameFactory implements IStyleFrameFactory
{
//    protected const SEQUENCE_START = C::EMPTY_STRING;
//    protected const SEQUENCE_END = C::EMPTY_STRING;

    public function create(mixed $style, ?string $format): IStyleFrame
    {
        if($style instanceof IStyleFrame) {
            return $style;
        }

        if (is_scalar($style)) {
            $style = [$style];
        }

        return
            new StyleFrame(
                Sequencer::colorSequenceStart(sprintf($format, ...$style)),
                Sequencer::colorSequenceEnd()
            );
    }
}
