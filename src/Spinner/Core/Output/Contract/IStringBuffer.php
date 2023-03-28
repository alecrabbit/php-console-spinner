<?php
declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

use Generator;

interface IStringBuffer
{
    /**
     * Writes message to buffer.
     *
     * @param string $message
     * @return IStringBuffer
     */
    public function write(string $message): IStringBuffer;

    /**
     * Returns buffer content and flushes it.
     *
     * @return Generator
     */
    public function flush(): Generator;
}