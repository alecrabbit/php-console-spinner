<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISpinner
{
    public function interval(): int|float;

    public function isAsync(): bool;

    public function spin(): void;

    public function begin(): void;

    public function end(): void;

    public function erase(): void;
}
