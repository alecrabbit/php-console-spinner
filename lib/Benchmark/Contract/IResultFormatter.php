<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IResultFormatter
{
    public function format(IResult $result): string;
}
