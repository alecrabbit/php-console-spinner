<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\Contract\IMemoryReportLoopSetup;
use AlecRabbit\Lib\Spinner\Core\DecoratedDriverLinker;
use AlecRabbit\Lib\Spinner\Factory\DecoratedDriverLinkerFactory;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DecoratedDriverLinkerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DecoratedDriverLinkerFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverLinkerFactory $driverLinkerFactory = null,
        ?IDriverInfoPrinter $infoPrinter = null,
        ?ILoopProvider $loopProvider = null,
        ?IMemoryReportSetupFactory $loopSetupFactory = null,
    ): IDecoratedDriverLinkerFactory {
        return
            new DecoratedDriverLinkerFactory(
                driverLinkerFactory: $driverLinkerFactory ?? $this->getDriverLinkerFactoryMock(),
                infoPrinter: $infoPrinter ?? $this->getIntervalPrinterMock(),
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
                loopSetupFactory: $loopSetupFactory ?? $this->getMemoryReportLoopSetupFactoryMock(),
            );
    }

    private function getDriverLinkerFactoryMock(): MockObject&IDriverLinkerFactory
    {
        return $this->createMock(IDriverLinkerFactory::class);
    }

    private function getIntervalPrinterMock(): MockObject&IDriverInfoPrinter
    {
        return $this->createMock(IDriverInfoPrinter::class);
    }

    private function getMemoryReportLoopSetupMock(): MockObject&IMemoryReportLoopSetup
    {
        return $this->createMock(IMemoryReportLoopSetup::class);
    }

    #[Test]
    public function canCreateDummyDriverLinker(): void
    {
        $dummyLinker = new DummyDriverLinker();

        $driverLinkerFactory = $this->getDriverLinkerFactoryMock();
        $driverLinkerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($dummyLinker)
        ;

        $factory = $this->getTesteeInstance(
            driverLinkerFactory: $driverLinkerFactory,
        );

        $linker = $factory->create();

        self::assertSame($dummyLinker, $linker);
    }

    #[Test]
    public function canCreate(): void
    {
        $driverLinker = $this->getDriverLinkerMock();

        $driverLinkerFactory = $this->getDriverLinkerFactoryMock();
        $driverLinkerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driverLinker)
        ;

        $factory = $this->getTesteeInstance(
            driverLinkerFactory: $driverLinkerFactory,
        );

        $linker = $factory->create();

        self::assertInstanceOf(DecoratedDriverLinker::class, $linker);
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    private function getIntervalFormatterMock(): MockObject&IIntervalFormatter
    {
        return $this->createMock(IIntervalFormatter::class);
    }

    private function getMemoryReportLoopSetupFactoryMock(): MockObject&IMemoryReportSetupFactory
    {
        return $this->createMock(IMemoryReportSetupFactory::class);
    }
}
