<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


use AlecRabbit\Spinner\Core\Output\Contract\IOutput;

/**
 * @internal
 */
interface IWriter
{
    public function write(string ...$sequences): void;

    public function getOutput(): IOutput;
}
