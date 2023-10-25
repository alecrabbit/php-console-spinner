<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\BenchmarkResults;
use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class BenchmarkResultsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkResults::class, $factory);
    }

    private function getTesteeInstance(
        ?iterable $results = null,
    ): IBenchmarkResults {
        return
            new BenchmarkResults(
                results: $results ?? [],
            );
    }

    #[Test]
    public function canGetResults(): void
    {
        $results = $this->getTraversableMock();

        $benchmarkResults = $this->getTesteeInstance(
            results: $results
        );

        self::assertSame($results, $benchmarkResults->getResults());
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }
}
