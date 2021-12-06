<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

interface OutputInterface
{
    /**
     * Writes a message to the output.
     *
     * @param string|iterable<string> $messages The message as an iterable of strings or a single string
     * @param bool                    $newline  Whether to add a newline
     * @param int                     $options  A bitmask of options (one of the OUTPUT or VERBOSITY constants),
     * 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     */
    public function write($messages, $newline = false, $options = 0): void;

    /**
     * Writes a message to the output and adds a newline at the end.
     *
     * @param string|iterable<string> $messages The message as an iterable of strings or a single string
     * @param int                     $options  A bitmask of options (one of the OUTPUT or VERBOSITY constants),
     * 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     */
    public function writeln($messages, $options = 0): void;

    /**
     * @return resource
     */
    public function getStream();
}
