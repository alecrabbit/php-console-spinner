<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;

/**
 * @internal
 */
final class Driver
{
    public function __construct(
        private IOutput $output
    ) {
    }

    public function write(string ...$sequences): void
    {
        $this->output->write($sequences);
    }

    public function frameSequence(string $fg, string $char): string
    {
        return "\033[38;5;{$fg}m{$char}\033[0m";
    }

}
