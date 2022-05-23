<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


/**
 * @internal
 */
interface ISequencer
{
    public function frameSequence(string $sequence): string;

    public function moveBackSequence(int $i = 1): string;

    public function eraseSequence(int $i = 1): string;

    public function hideCursorSequence(): string;

    public function showCursorSequence(): string;
}
