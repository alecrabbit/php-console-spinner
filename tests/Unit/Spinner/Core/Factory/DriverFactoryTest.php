<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverFactory::class, $driverFactory);
    }

    public function getTesteeInstance(
        ?IDriverBuilder $driverBuilder = null,
        ?IDriverOutputFactory $driverOutputFactory = null,
        ?ITimerFactory $timerFactory = null,
    ): IDriverFactory {
        return
            new DriverFactory(
                driverBuilder: $driverBuilder ?? $this->getDriverBuilderMock(),
                driverOutputFactory: $driverOutputFactory ?? $this->getDriverOutputFactoryMock(),
                timerFactory: $timerFactory ?? $this->getTimerFactoryMock(),
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $driverStub = $this->getDriverStub();

        $driverBuilder = $this->getDriverBuilderMock();

        $driverBuilder
            ->expects(self::once())
            ->method('withDriverOutput')
            ->willReturnSelf()
        ;

        $driverBuilder
            ->expects(self::once())
            ->method('withTimer')
            ->willReturnSelf()
        ;

        $driverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driverStub)
        ;

        $timerFactory = $this->getTimerFactoryMock();
        $timerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getTimerStub())
        ;

        $driverOutputFactory = $this->getDriverOutputFactoryMock();

        $driverOutputFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getDriverOutputStub())
        ;


        $driverFactory =
            $this->getTesteeInstance(
                driverBuilder: $driverBuilder,
                driverOutputFactory: $driverOutputFactory,
                timerFactory: $timerFactory
            );

        self::assertSame($driverStub, $driverFactory->create());
    }

}
