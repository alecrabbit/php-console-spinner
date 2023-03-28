<?php
declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IOutputBuffer
{
    /**
     * Writes message to buffer.
     *
     * @param string $message
     * @return IOutputBuffer
     */
    public function write(string $message): IOutputBuffer;

    /**
     * Returns buffer content and flushes it.
     *
     * @return string
     */
    public function flush(): string;
}