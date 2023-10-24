<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;


use AlecRabbit\Benchmark\BenchmarkResults;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Factory\BenchmarkResultsFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkResultsFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkResultsFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IResultMaker $resultMaker = null,
    ): IBenchmarkResultsFactory {
        return
            new BenchmarkResultsFactory(
                resultMaker: $resultMaker ?? $this->getResultMakerMock(),
            );
    }

    private function getResultMakerMock(): MockObject&IResultMaker
    {
        return $this->createMock(IResultMaker::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $measurements = $this->getTraversableMock();
        $factory = $this->getTesteeInstance();

        $benchmarkResults = $factory->create($measurements);

        self::assertInstanceOf(BenchmarkResultsFactory::class, $factory);
        self::assertInstanceOf(BenchmarkResults::class, $benchmarkResults);
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

}
