<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use Closure;

interface IWrapper
{
    /**
     * Wraps/decorates $closure with spinner erase() and spin() actions.
     */
    public function wrap(Closure $closure, ...$args): void;
}
