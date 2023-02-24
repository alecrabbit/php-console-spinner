<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IWrapper
{
    /**
     * Wraps/decorates $callable with spinner erase() and spin() actions.
     * Note: Signature is subject to change.
     * TODO (2022-10-11 11:52) [Alec Rabbit]: Signature is subject to change.
     */
    public function wrap(\Closure $closure, ...$args): void;
}
