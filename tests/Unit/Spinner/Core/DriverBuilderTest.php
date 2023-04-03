<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\ICursorBuilder;
use AlecRabbit\Spinner\Core\IOutputBuilder;
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
        ?ITimerBuilder $timerFactory = null,
        ?IOutputBuilder $outputBuilder = null,
        ?ICursorBuilder $cursorBuilder = null,
    ): IDriverBuilder {
        return
            new DriverBuilder(
                timerBuilder: $timerFactory ?? $this->getTimerFactoryMock(),
                outputBuilder: $outputBuilder ?? $this->getOutputBuilderMock(),
                cursorBuilder: $cursorBuilder ?? $this->getCursorBuilderMock(),
            );
    }

    #[Test]
    public function canBuildDriverWithConfig(): void
    {
        $outputBuilder = $this->getOutputBuilderMock();

        $outputBuilder
            ->method('withStream')
            ->willReturn($outputBuilder);

        $outputBuilder
            ->method('build')
            ->willReturn($this->getBufferedOutputMock());

        $driverBuilder = $this->getTesteeInstance(outputBuilder: $outputBuilder);

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);

        $auxConfig = $this->getAuxConfigMock();
        $auxConfig
            ->method('getOutputStream')
            ->willReturn(STDERR);
        $auxConfig
            ->method('getCursorOption')
            ->willReturn(OptionCursor::ENABLED);

        $driverConfig = new DriverConfig('interrupted', 'finished');

        $driver =
            $driverBuilder
                ->withAuxConfig($auxConfig)
                ->withDriverConfig($driverConfig)
                ->build();

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
