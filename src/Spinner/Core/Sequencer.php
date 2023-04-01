<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISequencer;

final class Sequencer implements ISequencer
{
    private const ESC = "\033";
    private const CSI = self::ESC . '[';
    private const RESET = self::CSI . '0m';
    private const SEQ_HIDE_CURSOR = '?25l';
    private const SEQ_SHOW_CURSOR = '?25h';

    public function colorSequence(string $sequence): string
    {
        return self::colorSequenceStart($sequence) . self::colorSequenceEnd();
    }

    private static function colorSequenceStart(string $sequence): string
    {
        return self::CSI . $sequence;
    }

    private static function colorSequenceEnd(): string
    {
        return self::RESET;
    }
}
