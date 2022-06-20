<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Kernel\Contract\IWriter;
use AlecRabbit\Spinner\Kernel\Output\Contract\IOutput;

/**
 * @internal
 */
final class Writer implements IWriter
{
    public function __construct(
        protected readonly IOutput $output
    ) {
    }

    public function write(string ...$sequences): void
    {
        $this->output->write($sequences);
    }

    public function getOutput(): IOutput
    {
        return $this->output;
    }
}
