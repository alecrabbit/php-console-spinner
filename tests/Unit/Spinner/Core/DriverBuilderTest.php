<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ICursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class DriverBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $configBuilder);
    }

    public function getTesteeInstance(
        ?ITimerFactory $timerFactory = null,
        ?IOutputFactory $outputFactory = null,
        ?ICursorFactory $cursorFactory = null,
    ): IDriverBuilder {
        return
            new DriverBuilder(
                timerFactory: $timerFactory ?? $this->getTimerFactoryMock(),
                outputFactory: $outputFactory ?? $this->getOutputFactoryMock(),
                cursorFactory: $cursorFactory ?? $this->getCursorFactoryMock(),
            );
    }

    #[Test]
    public function canBuildDriverWithDriverConfig(): void
    {
        $outputFactory = $this->getOutputFactoryMock();
        $outputFactory
            ->expects(self::once())
            ->method('getOutput')
            ->willReturn($this->getBufferedOutputMock());

        $driverBuilder = $this->getTesteeInstance(outputFactory: $outputFactory);

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);

        $driverConfig = new DriverConfig('interrupted', 'finished');
        $driver = $driverBuilder->withDriverConfig($driverConfig)->build();

        self::assertInstanceOf(Driver::class, $driver);
    }

    #[Test]
    public function throwsOnBuildDriverWithoutDriverConfig(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = '[AlecRabbit\Spinner\Core\DriverBuilder]: Property $driverConfig is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $driver = $driverBuilder->build();

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
