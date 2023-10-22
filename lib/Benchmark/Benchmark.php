<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;

final class Benchmark implements IBenchmark
{
    private const LABEL_GLUE = ':';

    public function __construct(
        protected readonly IStopwatch $stopwatch,
        protected ?string $prefix = null,
    ) {
    }

    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    public function run(string $label, \Closure $callback, mixed ...$args): mixed
    {
        $key = $this->refineLabel($label);

        $this->stopwatch->start($key);
        $result = $callback(...$args);
        $this->stopwatch->stop($key);

        return $result;
    }

    private function refineLabel(string $label): string
    {
        return
            $this->prefix === null
                ? $label
                : $this->prefix . self::LABEL_GLUE . $label;
    }

    public function getStopwatch(): IStopwatch
    {
        return $this->stopwatch;
    }
}
