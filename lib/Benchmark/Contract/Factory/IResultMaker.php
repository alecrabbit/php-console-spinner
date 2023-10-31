<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Exception\MeasurementException;

interface IResultMaker
{
    /** @throws MeasurementException */
    public function make(IMeasurement $measurement): IResult;
}
