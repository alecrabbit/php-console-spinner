<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


use AlecRabbit\Spinner\Core\Output\Contract\IOutput;

/**
 * @internal
 */
interface IWriter
{
    public function getOutput(): IOutput;

    public function write(string ...$sequences): void;
}
