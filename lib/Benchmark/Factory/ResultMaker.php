<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Stopwatch\Result;

final class ResultMaker implements IResultMaker
{
    /** @inheritDoc */
    public function make(IMeasurement $measurement): IResult
    {
        return
            new Result(
                $measurement->getAverage(),
                $measurement->getMin(),
                $measurement->getMax(),
                $measurement->getCount(),
            );
    }
}
