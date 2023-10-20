<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Stopwatch\Measurement;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class MeasurementTest extends TestCase
{
    private const THRESHOLD = 2;
    private const LABEL = 'testLabel';

    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(Measurement::class, $measurement);
    }

    private function getTesteeInstance(
        ?int $threshold = null,
    ): IMeasurement {
        return
            new Measurement(
                threshold: $threshold ?? self::THRESHOLD,
            );
    }

    #[Test]
    public function createdEmpty(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertEquals(0, $measurement->getCount());
        self::assertEquals(2, $measurement->getThreshold());
    }

    #[Test]
    public function canAdd(): void
    {
        $measurement = $this->getTesteeInstance();

        $measurement->add(1);
        $measurement->add(2);
        $measurement->add(3);
        $measurement->add(4);

        self::assertEquals(2.5, $measurement->getAverage());
        self::assertEquals(4, $measurement->getCount());
        self::assertEquals(1, $measurement->getMin());
        self::assertEquals(4, $measurement->getMax());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can not return any.');

        self::assertEquals(-1, $measurement->getAny());
    }

    #[Test]
    public function canGetAny(): void
    {
        $measurement = $this->getTesteeInstance(
            threshold: 10,
        );

        $measurement->add(1);
        $measurement->add(2);
        $measurement->add(3);
        $measurement->add(4);

        self::assertEquals(2.5, $measurement->getAny());
    }

    #[Test]
    public function thresholdCanBeSet(): void
    {
        $threshold = 3;

        $measurement = $this->getTesteeInstance(threshold: $threshold);

        $measurement->add(1);
        $measurement->add(1);
        $measurement->add(1);
        $measurement->add(1);

        self::assertSame(1, $measurement->getAverage());
        self::assertSame(4, $measurement->getCount());
        self::assertSame(1, $measurement->getMin());
        self::assertSame(1, $measurement->getMax());

        self::assertSame(
            $measurement->getThreshold(),
            $threshold
        );
    }

    #[Test]
    public function checkDefaultValues(): void
    {
        $expectedDefaultThreshold = 2;

        $measurement = new Measurement();

        self::assertEquals($expectedDefaultThreshold, $measurement->getThreshold());

    }

    #[Test]
    public function throwsMinIsNotSet(): void
    {
        $measurement = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Min is not set.');

        $measurement->getMin();
    }

    #[Test]
    public function throwsMaxIsNotSet(): void
    {
        $measurement = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Max is not set.');

        $measurement->getMax();
    }

    #[Test]
    public function throwsNotEnoughData(): void
    {
        $measurement = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not enough data.');

        $measurement->getAverage();
    }
}
