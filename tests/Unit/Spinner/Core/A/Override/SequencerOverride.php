<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A\Override;

use AlecRabbit\Spinner\Contract\ISequencer;

final class SequencerOverride implements ISequencer
{
    public static function colorSequence(string $sequence): string
    {
        return $sequence;
    }

    public static function moveBackSequence(int $i = 1): string
    {
        throw new \RuntimeException('Not implemented');
    }

    public static function eraseSequence(int $i = 1): string
    {
        throw new \RuntimeException('Not implemented');
    }

    public static function hideCursorSequence(): string
    {
        throw new \RuntimeException('Not implemented');
    }

    public static function showCursorSequence(): string
    {
        throw new \RuntimeException('Not implemented');
    }
}