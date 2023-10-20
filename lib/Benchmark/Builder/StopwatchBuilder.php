<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Builder;

use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Stopwatch\Stopwatch;
use ReflectionFunction;
use Throwable;

final class StopwatchBuilder implements IStopwatchBuilder
{
    private ?ITimer $timer = null;
    private ?\Closure $measurementSpawner = null;

    public function build(): IStopwatch
    {
        $this->validate();

        return
            new Stopwatch(
                timer: $this->timer,
                requiredMeasurements: 0,
            );
    }

    private function validate(): void
    {
        match (true) {
            null === $this->timer => throw new \LogicException('Timer is not set.'),
            null === $this->measurementSpawner => throw new \LogicException('Measurement spawner is not set.'),
            default => null,
        };

        self::assertSpawner($this->measurementSpawner);
    }

    private static function assertSpawner(?\Closure $spawner): void
    {
        try {
            $spawner();
        } catch (Throwable $e) {
            $message =
                sprintf(
                    '%s: %s.',
                    'Measurement spawner invocation throws',
                    $e->getMessage()
                );
            throw new \InvalidArgumentException(message: $message, previous: $e);
        }

        $reflection = new ReflectionFunction($spawner);

        $returnType = $reflection->getReturnType();
        if ($returnType === null) {
            throw new \InvalidArgumentException(
                'Return type of time function is not specified.'
            );
        }

        self::assertReturnType($returnType);
    }

    private static function assertReturnType(
        \ReflectionIntersectionType|\ReflectionNamedType|\ReflectionUnionType $returnType
    ): void {
    }

    public function withTimer(ITimer $timer): IStopwatchBuilder
    {
        $clone = clone $this;
        $clone->timer = $timer;
        return $clone;
    }

    public function withMeasurementSpawner(\Closure $spawner): IStopwatchBuilder
    {
        $clone = clone $this;
        $clone->measurementSpawner = $spawner;
        return $clone;
    }
}
