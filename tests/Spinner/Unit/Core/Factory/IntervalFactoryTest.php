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
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = new Interval();
        $intervalNormalizer
            ->expects(self::exactly(2))
            ->method('normalize')
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createDefault();
        self::assertInstanceOf(Interval::class, $result);
        self::assertSame($interval, $result);

        self::assertSame($interval, $intervalFactory->createDefault());
        self::assertSame($interval, $intervalFactory->createDefault());
        self::assertSame($interval, $intervalFactory->createDefault());
    }

    #[Test]
    public function canCreateStillInterval(): void
    {
        $interval = new Interval();
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->expects(self::exactly(2))
            ->method('normalize')
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createStill();

        self::assertInstanceOf(Interval::class, $result);
        self::assertSame($interval, $result);
    }

    #[Test]
    public function canCreateNormalizedInterval(): void
    {
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = new Interval();
        $intervalNormalizer
            ->method('normalize')
            ->with(self::isInstanceOf(Interval::class))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createNormalized(100);

        self::assertInstanceOf(Interval::class, $result);
        self::assertSame($interval, $result);
    }

    #[Test]
    public function canCreateNormalizedIntervalWithNull(): void
    {
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = $this->getIntervalMock();
        $intervalNormalizer
            ->expects(self::exactly(2))
            ->method('normalize')
            ->with(self::isInstanceOf(Interval::class))
            ->willReturn($interval)
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $result = $intervalFactory->createNormalized(null);

        self::assertSame($interval, $result);
        self::assertSame($interval, $intervalFactory->createNormalized(null));
        self::assertSame($interval, $intervalFactory->createNormalized(null));
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }
}
