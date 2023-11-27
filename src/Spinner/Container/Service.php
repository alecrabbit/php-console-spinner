<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IService;

final readonly class Service implements IService
{
    public function __construct(
        private mixed $value,
        private bool $storable,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function isStorable(): bool
    {
        return $this->storable;
    }
}
