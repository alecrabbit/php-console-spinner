<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IProbesLoader;

final class ProbesLoader implements IProbesLoader
{
    public function load(string $filter): \Traversable
    {
        return Probes::load($filter);
    }
}
