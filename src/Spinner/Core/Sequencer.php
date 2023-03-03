<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISequencer;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

use const AlecRabbit\Spinner\CSI;
use const AlecRabbit\Spinner\RESET;

/** @internal */
final class Sequencer implements ISequencer
{
    use NoInstanceTrait;

    private const SEQ_HIDE_CURSOR = '?25l';
    private const SEQ_SHOW_CURSOR = '?25h';

    public static function colorSequence(string $sequence): string
    {
        return self::colorSequenceStart($sequence) . self::colorSequenceEnd();
    }

    public static function colorSequenceStart(string $sequence): string
    {
        return CSI . $sequence;
    }

    public static function colorSequenceEnd(): string
    {
        return RESET;
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
