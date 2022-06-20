<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;


/**
 * @internal
 */
interface IWriter
{
    public function write(string ...$sequences): void;
}
