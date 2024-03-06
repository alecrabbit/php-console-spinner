<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IProbesLoader
{
    public function load(string $filter): \Traversable;
}
