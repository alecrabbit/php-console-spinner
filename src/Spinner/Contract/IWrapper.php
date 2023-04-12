<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use Closure;

interface IWrapper
{
    public function wrap(Closure $closure, mixed ...$args): void;
}
