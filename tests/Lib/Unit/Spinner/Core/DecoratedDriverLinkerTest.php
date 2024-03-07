<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core;


use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\Core\DecoratedDriverLinker;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DecoratedDriverLinkerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $linker = $this->getTesteeInstance();

        self::assertInstanceOf(DecoratedDriverLinker::class, $linker);
    }

    private function getTesteeInstance(
        ?IDriverLinker $linker = null,
        ?IDriverInfoPrinter $infoPrinter = null,
        ?ILoopProvider $loopProvider = null,
        ?IMemoryReportLoopSetupFactory $loopSetupFactory = null,
    ): IDriverLinker {
        return
            new DecoratedDriverLinker(
                linker: $linker ?? $this->getDriverLinkerMock(),
                infoPrinter: $infoPrinter ?? $this->getDriverInfoPrinterMock(),
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
                loopSetupFactory: $loopSetupFactory ?? $this->getMemoryReportLoopSetupFactoryMock(),
            );
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    private function getDriverInfoPrinterMock(): MockObject&IDriverInfoPrinter
    {
        return $this->createMock(IDriverInfoPrinter::class);
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
        $printer = $this->getDriverInfoPrinterMock();

        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
            infoPrinter: $printer,
        );

        $driver = $this->getDriverMock();
        $printer
            ->expects(self::once())
            ->method('print')
            ->with($driver)
        ;

        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with($driver)
        ;

        $driver
            ->expects(self::once())
            ->method('attach')
            ->with($linker)
        ;

        $linker->link($driver);
    }

    #[Test]
    public function canLinkEvenIfThereWasAnException(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $output = $this->getOutputMock();
        $printer = $this->getDriverInfoPrinterMock();


        $linker = $this->getTesteeInstance(
            linker: $driverLinker,
            infoPrinter: $printer,
        );

        $driver = $this->getDriverMock();

        $printer
            ->expects(self::once())
            ->method('print')
            ->with($driver)
        ;

        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with($driver)
            ->willThrowException(new ObserverCanNotBeOverwritten())
        ;

        $driver
            ->expects(self::once())
            ->method('attach')
            ->with($linker)
        ;

        $linker->link($driver);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    private function getMemoryReportLoopSetupMock(): MockObject&IMemoryReportLoopSetup
    {
        return $this->createMock(IMemoryReportLoopSetup::class);
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    private function getMemoryReportLoopSetupFactoryMock(): MockObject&IMemoryReportLoopSetupFactory
    {
        return $this->createMock(IMemoryReportLoopSetupFactory::class);
    }
}
