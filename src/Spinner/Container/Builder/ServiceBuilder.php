<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Builder;

use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceBuilder;
use AlecRabbit\Spinner\Container\Service;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class ServiceBuilder implements IServiceBuilder
{
    private mixed $value;
    private ?bool $isStorable = null;
    private ?string $id = null;

    public function build(): IService
    {
        $this->validate();

        return new Service(
            value: $this->value,
            storable: $this->isStorable,
            id: $this->id,
        );
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->value) => throw new \InvalidArgumentException('Value is not set.'),
            $this->id === null => throw new \InvalidArgumentException('Id is not set.'),
            $this->isStorable=== null => throw new \InvalidArgumentException('isStorable is not set.'),
            default => null,
        };
    }

    public function withValue(mixed $value): IServiceBuilder
    {
        $clone = clone $this;
        $clone->value = $value;
        return $clone;
    }

    public function withId(string $id): IServiceBuilder
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }

    public function withIsStorable(bool $isStorable): IServiceBuilder
    {
        $clone = clone $this;
        $clone->isStorable = $isStorable;
        return $clone;
    }
}
