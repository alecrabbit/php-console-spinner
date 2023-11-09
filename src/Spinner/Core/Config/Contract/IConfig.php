<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;

interface IConfig
{
    /**
     * @param IConfigElement ...$configElements
     * @throws InvalidArgument
     */
    public function set(IConfigElement ...$configElements): void;

    /**
     * @template T of IConfigElement
     * @param class-string<T> $id
     *
     * @psalm-return T
     *
     * @throws InvalidArgument
     */
    public function get(string $id): IConfigElement;
}
