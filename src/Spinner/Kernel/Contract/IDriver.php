<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;


/**
 * @internal
 */
interface IDriver
{
    public function hideCursor(): void;

    public function showCursor(): void;

    public function erase(?int $i = null): void;

    public function getTerminalColorSupport(): int;

    public function message(string $message): void;
}
