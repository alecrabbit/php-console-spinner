<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IStaticSequencer
{
    public static function colorSequence(string $sequence): string;

    public static function moveBackSequence(int $i = 1): string;

    public static function eraseSequence(int $i = 1): string;

    public static function hideCursorSequence(): string;

    public static function showCursorSequence(): string;
}
