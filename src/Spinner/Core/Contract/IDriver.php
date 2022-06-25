<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


/**
 * @internal
 */
interface IDriver
{
    public function hideCursor(): void;

    public function showCursor(): void;

    public function erase(int $i): void;

    public function getTerminalColorSupport(): int;

    public function message(string $message): void;

    public function display(iterable $sequence): int;
}
