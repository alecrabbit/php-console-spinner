<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISpinner
{
    public function interval(): int|float;

    public function isAsync(): bool;

    public function spin(): void;
}
