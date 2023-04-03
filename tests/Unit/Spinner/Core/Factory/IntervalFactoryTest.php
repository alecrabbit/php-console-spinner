<?php

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class IntervalFactoryTest extends TestCaseWithPrebuiltMocks
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
            );
        $intervalFactory = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalFactory::class, $intervalFactory);
    }

    public function getTesteeInstance(
        ?IIntervalNormalizer $intervalNormalizer = null,
    ): IIntervalFactory {
        return
            new IntervalFactory(
                intervalNormalizer: $intervalNormalizer ?? $this->getIntervalNormalizerMock(),
            );
    }

    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->method('normalize')
            ->willReturn(new Interval());

        $intervalFactory = $this->getTesteeInstance(intervalNormalizer: $intervalNormalizer);

        $interval = $intervalFactory->createDefault();

        self::assertInstanceOf(Interval::class, $interval);
    }

    #[Test]
    public function canCreateStillInterval(): void
    {
        $container = $this->getContainerMock();

        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->method('getAuxSettings')
            ->willReturn($this->getAuxSettingsMock());

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->method('normalize')
            ->willReturn(new Interval());

        $container
            ->method('get')
            ->willReturn(
                $defaultsProvider,
                $intervalNormalizer,
            );

        $intervalFactory = $this->getTesteeInstance();

        $interval = $intervalFactory->createStill();

        self::assertInstanceOf(Interval::class, $interval);
    }

}
