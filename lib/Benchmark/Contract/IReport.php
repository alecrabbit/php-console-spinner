<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract;

interface IReport
{
    public function getTitle(): string;

    public function getPrefix(): string;

    /**
     * @return iterable<string, IResult>
     */
    public function getResults(): iterable;
}
