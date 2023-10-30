<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IConsoleCursor
{
    /**
     * Hides cursor.
     */
    public function show(): IConsoleCursor;

    /**
     * Shows cursor.
     */
    public function hide(): IConsoleCursor;

    /**
     * Moves cursor left by $columns. Requires buffer flushing.
     */
    public function moveLeft(int $columns = 1): IConsoleCursor;

    /**
     * Erases $width characters from the current position. Requires buffer flushing.
     */
    public function erase(int $width): IConsoleCursor;
}
