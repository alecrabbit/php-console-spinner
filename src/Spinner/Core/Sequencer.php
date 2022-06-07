<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISequencer;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;

final class Sequencer implements ISequencer
{
    private const SEQ_HIDE_CURSOR = '?25l';
    private const SEQ_SHOW_CURSOR = '?25h';

    public function frameSequence(string $sequence): string
    {
        return CSI . $sequence . RESET;
    }

    public function moveBackSequence(int $i = 1): string
    {
        return CSI . "{$i}D";
    }

    public function eraseSequence(int $i = 1): string
    {
        return CSI . "{$i}X";
    }

    public function hideCursorSequence(): string
    {
        return CSI . self::SEQ_HIDE_CURSOR;
    }

    public function showCursorSequence(): string
    {
        return CSI . self::SEQ_SHOW_CURSOR;
    }
}