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

    public function wrap(callable $callback, ...$args): void;
}
