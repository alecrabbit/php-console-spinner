<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IBenchmarkResults
{
    /**
     * @return iterable<string, IResult>
     */
    public function getResults(): iterable;
}
