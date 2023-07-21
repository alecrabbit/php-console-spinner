<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class IntervalFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $container = $this->getContainerMock();
        $container
            ->method('get')
            ->willReturn(
                $this->getLegacySettingsProviderMock(),
                $this->getIntervalNormalizerMock(),
            )
        ;
        $intervalFactory = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalFactory::class, $intervalFactory);
    }

    public function getTesteeInstance(
        ?IIntervalNormalizer $intervalNormalizer = null,
    ): IIntervalFactory {
        self::setPropertyValue(IntervalFactory::class, 'normalizedDefaultInterval', null);
        return new IntervalFactory(
            intervalNormalizer: $intervalNormalizer ?? $this->getIntervalNormalizerMock(),
        );
    }

    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $interval = new Interval();
        $intervalNormalizer
            ->expects(self::once())
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
            ->expects(self::once())
            ->method('normalize')
            ->with($interval)
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
            ->expects(self::once())
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

    protected function setUp(): void
    {
        self::setPropertyValue(IntervalFactory::class, 'normalizedDefaultInterval', null);
        self::setPropertyValue(IntervalFactory::class, 'normalizedStillInterval', null);
    }
}
