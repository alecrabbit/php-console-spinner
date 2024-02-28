<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class IntervalFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $intervalFactory = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalFactory::class, $intervalFactory);
    }

    public function getTesteeInstance(
        ?IIntervalNormalizer $intervalNormalizer = null,
    ): IIntervalFactory {
        return new IntervalFactory(
            intervalNormalizer: $intervalNormalizer ?? $this->getIntervalNormalizerMock(),
        );
    }

    protected function getIntervalNormalizerMock(): MockObject&IIntervalNormalizer
    {
        return $this->createMock(IIntervalNormalizer::class);
    }

    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $sample = new Interval(1000);
        $interval = $this->getIntervalMock();
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($this->equalTo($sample))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createDefault();
        self::assertSame($interval, $result);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canCreateStillInterval(): void
    {
        $sample = new Interval();
        $interval = $this->getIntervalMock();
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($this->equalTo($sample))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createStill();

        self::assertSame($interval, $result);
    }

    #[Test]
    public function canCreateNormalizedInterval(): void
    {
        $value = 300;
        $sample = new Interval($value);

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = $this->getIntervalMock();
        $intervalNormalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($this->equalTo($sample))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createNormalized($value);

        self::assertSame($interval, $result);
    }

    #[Test]
    public function canCreateNormalizedIntervalWithZero(): void
    {
        $sample = new Interval(10);

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = $this->getIntervalMock();
        $intervalNormalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($this->equalTo($sample))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createNormalized(0);

        self::assertSame($interval, $result);
    }

    #[Test]
    public function canCreateNormalizedIntervalWithBigNumber(): void
    {
        $sample = new Interval(IInterval::MAX_INTERVAL_MILLISECONDS);

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = $this->getIntervalMock();
        $intervalNormalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($this->equalTo($sample))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createNormalized(IInterval::MAX_INTERVAL_MILLISECONDS + 1000);

        self::assertSame($interval, $result);
    }

    #[Test]
    public function canCreateNormalizedIntervalWithNull(): void
    {
        $value = null;
        $sample = new Interval($value);
        $interval = $this->getIntervalMock();

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($this->equalTo($sample))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createNormalized($value);

        self::assertSame($interval, $result);
    }
}
