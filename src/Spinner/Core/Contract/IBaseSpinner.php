<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IBaseSpinner
{
    public function spin(): void;

    public function initialize(): void;

    public function interrupt(): void;

    public function finalize(): void;

    public function erase(): void;

    public function deactivate(): void;

    public function activate(): void;

    /**
     * Wraps/decorates $callable with spinner erase() and spin() actions.
     * Note: Signature is subject to change.
     */
    public function wrap(callable $callback, ...$args): void; // TODO (2022-10-11 11:52) [Alec Rabbit]: Signature is subject to change.
}
