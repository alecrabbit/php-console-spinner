<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


/**
 * @internal
 */
interface IDriver
{
    public function frameSequence(string $fg, string $char): string;

    public function moveBackSequence(int $i = 1): string;

    public function eraseSequence(int $i = 1): string;

    public function hideCursor(): void;

    public function write(string ...$sequences): void;

    public function showCursor(): void;

    public function getOutput(): IOutput;
}
