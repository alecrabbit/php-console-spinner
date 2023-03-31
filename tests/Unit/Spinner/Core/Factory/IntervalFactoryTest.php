<?php

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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
            )
        ;
        $intervalFactory = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(IntervalFactory::class, $intervalFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IIntervalFactory {
        return
            new IntervalFactory(
                container: $container ?? $this->getContainerMock(),
            );
    }

    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $container = $this->getContainerMock();

        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->method('getAuxSettings')
            ->willReturn($this->getAuxSettingsMock())
        ;

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->method('normalize')
            ->willReturn(new Interval())
        ;

        $container
            ->method('get')
            ->willReturn(
                $defaultsProvider,
                $intervalNormalizer,
            )
        ;

        $intervalFactory = $this->getTesteeInstance(container: $container);

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
            ->willReturn($this->getAuxSettingsMock())
        ;

        $intervalNormalizer = $this->getIntervalNormalizerMock();
        $intervalNormalizer
            ->method('normalize')
            ->willReturn(new Interval())
        ;

        $container
            ->method('get')
            ->willReturn(
                $defaultsProvider,
                $intervalNormalizer,
            )
        ;

        $intervalFactory = $this->getTesteeInstance(container: $container);

        $interval = $intervalFactory->createStill();

        self::assertInstanceOf(Interval::class, $interval);
    }

}
