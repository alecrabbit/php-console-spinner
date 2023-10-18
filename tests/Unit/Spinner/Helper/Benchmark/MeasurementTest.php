<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Helper\Benchmark;

use AlecRabbit\Spinner\Helper\Benchmark\Contract\IMeasurement;
use AlecRabbit\Spinner\Helper\Benchmark\Measurement;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class MeasurementTest extends TestCase
{
    private const THRESHOLD_VALUE = 2;
    private const LABEL_VALUE = 'test';
    private const THRESHOLD = 'threshold';
    private const LABEL = 'label';
    const REJECT_FIRST_VALUE = 10;

    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(Measurement::class, $measurement);
    }

    private function getTesteeInstance(
        ?int $threshold = null,
        ?string $label = null,
        ?int $rejectFirst = null,
    ): IMeasurement {
        return
            new Measurement(
                threshold: $threshold ?? self::THRESHOLD_VALUE,
                label: $label ?? self::LABEL_VALUE,
                rejectFirst: $rejectFirst ?? self::REJECT_FIRST_VALUE,
            );
    }

    #[Test]
    public function createdEmpty(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertEquals(0, $measurement->getCount());
        self::assertEquals(self::LABEL_VALUE, $measurement->getLabel());
    }

    #[Test]
    public function canBeInstantiatedWithCustomLabel(): void
    {
        $label = 'custom';

        $measurement = $this->getTesteeInstance(label: $label);

        self::assertSame($label, $measurement->getLabel());
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

    #[Test]
    public function canAdd(): void
    {
        $measurement = $this->getTesteeInstance(
            rejectFirst: 0,
        );

        $measurement->add(1);
        $measurement->add(2);
        $measurement->add(3);
        $measurement->add(4);

        self::assertEquals(2.5, $measurement->getAverage());
        self::assertEquals(4, $measurement->getCount());
        self::assertEquals(1, $measurement->getMin());
        self::assertEquals(4, $measurement->getMax());
    }

    #[Test]
    public function thresholdCanBeSet(): void
    {
        $threshold = 3;

        $measurement = $this->getTesteeInstance(
            threshold: $threshold,
            rejectFirst: 0,
        );

        $measurement->add(1);
        $measurement->add(1);
        $measurement->add(1);
        $measurement->add(1);

        self::assertSame(1, $measurement->getAverage());
        self::assertSame(4, $measurement->getCount());
        self::assertSame(1, $measurement->getMin());
        self::assertSame(1, $measurement->getMax());

        self::assertSame(
            self::getPropertyValue(self::THRESHOLD, $measurement),
            $threshold
        );
    }

    #[Test]
    public function checkDefaultValues(): void
    {
        $expectedDefaultThreshold = 2;
        $expectedDefaultLabel = '--undefined--';

        $measurement = new Measurement();

        self::assertSame(
            self::getPropertyValue(self::THRESHOLD, $measurement),
            $expectedDefaultThreshold
        );

        self::assertSame(
            self::getPropertyValue(self::LABEL, $measurement),
            $expectedDefaultLabel
        );
    }
}
