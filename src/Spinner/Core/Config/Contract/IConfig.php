<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IConfig
{
    /**
     * @param IConfigElement ...$configElements
     * @throws InvalidArgumentException
     */
    public function set(IConfigElement ...$configElements): void;

    /**
     * @psalm-template T of IConfigElement
     * @psalm-param class-string<T> $id
     * @psalm-return T
     *
     * @throws InvalidArgumentException
     */
    public function get(string $id): IConfigElement;
}
