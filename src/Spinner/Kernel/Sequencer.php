<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Kernel\Contract\ISequencer;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;

final class Sequencer implements ISequencer
{
    private const SEQ_HIDE_CURSOR = '?25l';
    private const SEQ_SHOW_CURSOR = '?25h';

    public static function colorSequence(string $sequence): string
    {
        return CSI . $sequence . RESET;
    }

    public static function moveBackSequence(int $i = 1): string
    {
        return CSI . "{$i}D";
    }

    public static function eraseSequence(int $i = 1): string
    {
        return CSI . "{$i}X";
    }

    public static function hideCursorSequence(): string
    {
        return CSI . self::SEQ_HIDE_CURSOR;
    }

    public static function showCursorSequence(): string
    {
        return CSI . self::SEQ_SHOW_CURSOR;
    }
}
