<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Benchmark\Unit\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Factory\MeasurementFactory;
use AlecRabbit\Benchmark\Stopwatch\Measurement;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MeasurementFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(MeasurementFactory::class, $measurement);
    }

    private function getTesteeInstance(): IMeasurementFactory
    {
        return
            new MeasurementFactory();
    }


    #[Test]
    public function canCreate(): void
    {
        $factory = $this->getTesteeInstance();

        $measurement = $factory->create();

        self::assertInstanceOf(MeasurementFactory::class, $factory);
        self::assertInstanceOf(Measurement::class, $measurement);
    }

    private function getTimerMock(?TimeUnit $unit = null): MockObject&ITimer
    {
        return $this->createConfiguredMock(
            ITimer::class,
            [
                'getUnit' => $unit ?? TimeUnit::HOUR,
            ]
        );
    }
}
