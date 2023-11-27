<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Exception\MeasurementException;
use AlecRabbit\Benchmark\Stopwatch\Result;

final class ResultMaker implements IResultMaker
{
    public function make(IMeasurement $measurement): IResult
    {
        try {
            return new Result(
                $measurement->getAverage(),
                $measurement->getMin(),
                $measurement->getMax(),
                $measurement->getCount(),
            );
        } catch (MeasurementException $_) {
            return new Result(
                $measurement->getAny(),
                $measurement->getMin(),
                $measurement->getMax(),
                $measurement->getCount(),
            );
        }
    }
}
