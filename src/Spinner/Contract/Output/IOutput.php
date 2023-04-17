<?php

declare(strict_types=1);

// 28.03.23
namespace AlecRabbit\Spinner\Contract\Output;

interface IOutput
{
    /**
     * Writes a message or messages to the output and adds a newline at the end.
     *
     * @param string|iterable $messages Message or messages to write
     * @param int $options A bitmask of options
     */
    public function writeln(string|iterable $messages, int $options = 0): void;

    /**
     * Writes a message or messages to the output.
     *
     * @param string|iterable $messages Message or messages to write
     * @param bool $newline Whether to add a newline
     * @param int $options A bitmask of options
     */
    public function write(string|iterable $messages, bool $newline = false, int $options = 0): void;
}
