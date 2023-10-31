<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IResult;

class BenchmarkResults implements Contract\IBenchmarkResults
{
    /**
     * @param iterable<string, IResult> $results
     */
    public function __construct(
        protected iterable $results,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getResults(): iterable
    {
        return $this->results;
    }
}
