<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;

use AlecRabbit\Benchmark\Benchmark;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Factory\BenchmarkFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkFactory::class, $measurement);
    }

    private function getTesteeInstance(
        ?IStopwatchFactory $stopwatchFactory = null,
    ): IBenchmarkFactory {
        return
            new BenchmarkFactory(
                stopwatchFactory: $stopwatchFactory ?? $this->getStopwatchFactoryMock(),
            );
    }

    private function getStopwatchFactoryMock(): MockObject&IStopwatchFactory
    {
        return $this->createMock(IStopwatchFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $benchmarkFactory = $this->getTesteeInstance();

        $benchmark = $benchmarkFactory->create();

        self::assertInstanceOf(BenchmarkFactory::class, $benchmarkFactory);
        self::assertInstanceOf(Benchmark::class, $benchmark);
    }
}
