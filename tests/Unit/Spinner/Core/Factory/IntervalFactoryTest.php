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
                $this->getDefaultsProviderMock(),
                $this->getIntervalNormalizerMock(),
            )
        ;
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

    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->method('normalize')
            ->willReturn(new Interval())
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $interval = $intervalFactory->createDefault();

        self::assertInstanceOf(Interval::class, $interval);
    }

    #[Test]
    public function canCreateStillInterval(): void
    {
        $intervalFactory = $this->getTesteeInstance();

        $interval = $intervalFactory->createStill();

        self::assertInstanceOf(Interval::class, $interval);
    }

    #[Test]
    public function canCreateNormalizedInterval(): void
    {
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->method('normalize')
            ->willReturn(new Interval())
        ;

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $interval = $intervalFactory->createNormalized(100);

        self::assertInstanceOf(Interval::class, $interval);
    }
}
