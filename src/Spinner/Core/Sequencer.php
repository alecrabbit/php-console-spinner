<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\I\ISequencer;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

/** @internal */
final class Sequencer implements ISequencer
{
    use NoInstanceTrait;

    private const ESC = "\033";
    private const CSI = self::ESC . '[';
    private const RESET = self::CSI . '0m';
    private const SEQ_HIDE_CURSOR = '?25l';
    private const SEQ_SHOW_CURSOR = '?25h';

    public static function colorSequence(string $sequence): string
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

    public static function moveBackSequence(int $i = 1): string
    {
        return self::CSI . "{$i}D";
    }

    public static function eraseSequence(int $i = 1): string
    {
        return self::CSI . "{$i}X";
    }

    public static function hideCursorSequence(): string
    {
        return self::CSI . self::SEQ_HIDE_CURSOR;
    }

    public static function showCursorSequence(): string
    {
        return self::CSI . self::SEQ_SHOW_CURSOR;
    }
}
