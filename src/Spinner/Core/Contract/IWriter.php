<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


/**
 * @internal
 */
interface IWriter
{
    public function write(string ...$sequences): void;
}
