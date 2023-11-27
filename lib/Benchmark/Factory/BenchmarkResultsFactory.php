<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\BenchmarkResults;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Exception\MeasurementException;
use Traversable;

final class BenchmarkResultsFactory implements IBenchmarkResultsFactory
{
    public function __construct(
        protected IResultMaker $resultMaker,
    ) {
    }

    /** @inheritDoc */
    public function create(iterable $measurements): IBenchmarkResults
    {
        return new BenchmarkResults(
            $this->createResults($measurements),
        );
    }

    /**
     * @param iterable<string, IMeasurement> $measurements
     *
     * @return Traversable<string, IResult>
     */
    private function createResults(iterable $measurements): Traversable
    {
        /** @var string $key */
        /** @var IMeasurement $measurement */
        foreach ($measurements as $key => $measurement) {
            try {
                yield $key => $this->resultMaker->make($measurement);
            } catch (MeasurementException $_) {
                continue;
            }
        }
    }
}
