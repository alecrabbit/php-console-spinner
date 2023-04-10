<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\LegacyDriver;
use AlecRabbit\Spinner\Core\LegacyDriverBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class LegacyDriverBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyDriverBuilder::class, $configBuilder);
    }

    public function getTesteeInstance(
        ?ITimerBuilder $timerFactory = null,
        ?IBufferedOutputBuilder $outputBuilder = null,
        ?IConsoleCursorBuilder $cursorBuilder = null,
    ): ILegacyDriverBuilder {
        return
            new LegacyDriverBuilder(
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
            ->method('withStreamHandler')
            ->willReturn($outputBuilder)
        ;

        $outputBuilder
            ->method('build')
            ->willReturn($this->getBufferedOutputMock())
        ;

        $driverBuilder = $this->getTesteeInstance(outputBuilder: $outputBuilder);

        self::assertInstanceOf(LegacyDriverBuilder::class, $driverBuilder);

        $auxConfig = $this->getAuxConfigMock();
        $auxConfig
            ->method('getOutputStream')
            ->willReturn(STDERR)
        ;
        $auxConfig
            ->method('getCursorOption')
            ->willReturn(OptionCursor::VISIBLE)
        ;

        $driverConfig = new DriverConfig('interrupted', 'finished');

        $driver =
            $driverBuilder
                ->withAuxConfig($auxConfig)
                ->withDriverConfig($driverConfig)
                ->build()
        ;

        self::assertInstanceOf(LegacyDriver::class, $driver);
    }

    #[Test]
    public function throwsOnBuildDriverWithoutDriverConfig(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyDriverBuilder::class, $driverBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = '[AlecRabbit\Spinner\Core\LegacyDriverBuilder]: Property $driverConfig is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $driver = $driverBuilder->build();

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
