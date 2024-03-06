<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

/**
 * @template T of object
 */
interface IProbesLoader
{
    /**
     * @param class-string<T> $filter
     * @return \Traversable<class-string<T>>
     */
    public function load(string $filter): \Traversable;
}
