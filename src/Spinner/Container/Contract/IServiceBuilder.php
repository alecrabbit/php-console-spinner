<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceBuilder
{
    public function build(): IService;

    public function withValue(mixed $value): IServiceBuilder;

    public function withId(string $id): IServiceBuilder;

    public function withIsStorable(bool $isStorable): IServiceBuilder;
}
