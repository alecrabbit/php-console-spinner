<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IConsoleCursor
{
    /**
     * Show cursor.
     */
    public function show(): IConsoleCursor;

    /**
     * Hide cursor.
     */
    public function hide(): IConsoleCursor;

    /**
     * Move cursor left by $columns.
     */
    public function moveLeft(int $columns = 1): IConsoleCursor;

    /**
     * Erase $width characters from the current position.
     */
    public function erase(int $width): IConsoleCursor;
}
