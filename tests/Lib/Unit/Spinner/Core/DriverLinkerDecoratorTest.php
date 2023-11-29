<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core;


use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\Core\DriverLinkerDecorator;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverLinkerDecoratorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $linker = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerDecorator::class, $linker);
    }

    private function getTesteeInstance(
        ?IDriverLinker $linker = null,
        ?IOutput $output = null,
        ?IIntervalFormatter $intervalFormatter = null,
    ): IDriverLinker {
        return
            new DriverLinkerDecorator(
                linker: $linker ?? $this->getDriverLinkerMock(),
                output: $output ?? $this->getOutputMock(),
                intervalFormatter: $intervalFormatter ?? $this->getIntervalFormatterMock(),
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

    private function getIntervalFormatterMock(): MockObject&IIntervalFormatter
    {
        return $this->createMock(IIntervalFormatter::class);
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

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    #[Test]
    public function canLink(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $output = $this->getOutputMock();
        $formatter = $this->getIntervalFormatterMock();

        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
            output: $output,
            intervalFormatter: $formatter,
        );

        $interval = $this->getIntervalMock();
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $formatter
            ->expects(self::once())
            ->method('format')
            ->with($interval)
        ;

        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with($driver)
        ;


        $output
            ->expects(self::once())
            ->method('write')
        ;

        $driver
            ->expects(self::once())
            ->method('attach')
            ->with($linker)
        ;

        $linker->link($driver);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canLinkEvenIfThereWasAnException(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $output = $this->getOutputMock();
        $formatter = $this->getIntervalFormatterMock();

        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
            output: $output,
            intervalFormatter: $formatter,
        );

        $interval = $this->getIntervalMock();
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $formatter
            ->expects(self::once())
            ->method('format')
            ->with($interval)
        ;

        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with($driver)
            ->willThrowException(new ObserverCanNotBeOverwritten())
        ;

        $output
            ->expects(self::once())
            ->method('write')
        ;

        $driver
            ->expects(self::once())
            ->method('attach')
            ->with($linker)
        ;

        $linker->link($driver);
    }
}
