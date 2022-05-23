<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IOutput;

use AlecRabbit\Spinner\Core\Contract\IWriter;

final class Writer implements IWriter
{
    public function __construct(
        private readonly IOutput $output
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
