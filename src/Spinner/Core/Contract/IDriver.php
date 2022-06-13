<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;


/**
 * @internal
 */
interface IDriver
{
    public function hideCursor(): void;

    public function showCursor(): void;

    public function erase(?int $i = null): void;

    public function getWriter(): IWriter;

    public function getTerminalColorSupport(): int;

    public function write(string $message): void;
}
