<?php

declare(strict_types=1);

// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IConsoleCursor
{
    /**
     * Hides cursor.
     *
     * @return IConsoleCursor
     */
    public function show(): IConsoleCursor;

    /**
     * Shows cursor.
     *
     * @return IConsoleCursor
     */
    public function hide(): IConsoleCursor;

    /**
     * Moves cursor left by $columns. Requires buffer flushing.
     *
     * @param int $columns
     * @return IConsoleCursor
     */
    public function moveLeft(int $columns = 1): IConsoleCursor;

    /**
     * Erases $width characters from the current position. Requires buffer flushing.
     *
     * @param int $width
     * @return IConsoleCursor
     */
    public function erase(int $width): IConsoleCursor;

    public function flush(): IConsoleCursor;
}
