<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Output\ISequencer;

final class Sequencer implements ISequencer
{
    private const ESC = "\033";
    private const CSI = self::ESC . '[';
    private const RESET = self::CSI . '0m';
    private const COLOR_FORMAT = self::CSI . '%s' . self::RESET;

    public function colorSequence(string $sequence): string
    {
        return sprintf(self::COLOR_FORMAT, $sequence);
    }
}
