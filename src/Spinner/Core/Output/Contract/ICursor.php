<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

interface ICursor
{
    /**
     * Hides cursor.
     *
     * @return ICursor
     */
    public function show(): ICursor;

    /**
     * Shows cursor.
     *
     * @return ICursor
     */
    public function hide(): ICursor;

    /**
     * Moves cursor left by $columns. Requires flushing.
     *
     * @param int $columns
     * @return ICursor
     */
    public function moveLeft(int $columns = 1): ICursor;

    /**
     * Erases $width characters from the current position. Requires flushing.
     *
     * @param int $width
     * @return ICursor
     */
    public function erase(int $width): ICursor;

    public function flush(): ICursor;
}