<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;

abstract class AStyleFrameFactory implements IStyleFrameFactory
{
    protected const SEQUENCE_START = C::EMPTY_STRING;
    protected const SEQUENCE_END = C::EMPTY_STRING;

    public function create(
        string $sequenceStart = self::SEQUENCE_START,
        string $sequenceEnd = self::SEQUENCE_END,
    ): IStyleFrame {
        return
            new StyleFrame($sequenceStart, $sequenceEnd);
    }
}
