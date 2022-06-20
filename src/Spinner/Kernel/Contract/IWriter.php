<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;


use AlecRabbit\Spinner\Kernel\Output\Contract\IOutput;

/**
 * @internal
 */
interface IWriter
{
    public function getOutput(): IOutput;

    public function write(string ...$sequences): void;
}
