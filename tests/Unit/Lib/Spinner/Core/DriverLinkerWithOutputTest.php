<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Lib\Spinner\Core;


use AlecRabbit\Lib\Spinner\Core\DriverLinkerWithOutput;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverLinkerWithOutputTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $linker = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerWithOutput::class, $linker);
    }

    private function getTesteeInstance(
        ?IDriverLinker $linker = null,
        ?IOutput $output = null,
    ): IDriverLinker {
        return
            new DriverLinkerWithOutput(
                linker: $linker ?? $this->getDriverLinkerMock(),
                output: $output ?? $this->getOutputMock(),
            );
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    #[Test]
    public function canUpdate(): void
    {
        $driverLinker = $this->getDriverLinkerMock();

        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
        );

        $driver = $this->getDriverMock();

        $driverLinker
            ->expects(self::once())
            ->method('update')
            ->with($driver)
        ;

        $linker->update($driver);
    }

    #[Test]
    public function canLink(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $output = $this->getOutputMock();

        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
            output: $output,
        );

        $driver = $this->getDriverMock();

        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with($driver)
        ;

        $output
            ->expects(self::once())
            ->method('write')
            ->with('[Driver] Render interval: 100ms' . PHP_EOL)
        ;

        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(100.0)
        ;

        $driver
            ->expects(self::once())
            ->method('attach')
            ->with($linker)
        ;

        $driver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $linker->link($driver);
    }

    #[Test]
    public function canLinkEvenIfThereWasAnException(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $output = $this->getOutputMock();

        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
            output: $output,
        );

        $driver = $this->getDriverMock();

        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with($driver)
            ->willThrowException(new ObserverCanNotBeOverwritten())
        ;

        $output
            ->expects(self::once())
            ->method('write')
            ->with('[Driver] Render interval: 100ms' . PHP_EOL)
        ;

        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(100.0)
        ;

        $driver
            ->expects(self::once())
            ->method('attach')
            ->with($linker)
        ;

        $driver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $linker->link($driver);
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }
}
