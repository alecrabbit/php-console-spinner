<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IResult;
use Traversable;

interface IResultsFactory
{
    /**
     * @return Traversable<IResult>
     */
    public function create(): Traversable;
}
