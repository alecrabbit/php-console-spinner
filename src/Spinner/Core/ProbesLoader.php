<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use AlecRabbit\Spinner\Core\Contract\IProbesLoader;
use AlecRabbit\Spinner\Exception\InvalidArgument;

/**
 * @template T of IStaticProbe
 * @template-implements IProbesLoader<T>
 */
final class ProbesLoader implements IProbesLoader
{
    /**
     * @param class-string<T> $filter
     * @psalm-return \Traversable<class-string<T>>
     *
     * @throws InvalidArgument
     */
    public function load(string $filter): \Traversable
    {
        return Probes::load($filter);
    }
}
