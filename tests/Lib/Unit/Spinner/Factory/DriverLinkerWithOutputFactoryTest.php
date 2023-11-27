<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDriverLinkerWithOutputFactory;
use AlecRabbit\Lib\Spinner\Core\DriverLinkerWithOutput;
use AlecRabbit\Lib\Spinner\Factory\DriverLinkerWithOutputFactory;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverLinkerWithOutputFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerWithOutputFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverLinkerFactory $driverLinkerFactory = null,
        ?IOutput $output = null,
    ): IDriverLinkerWithOutputFactory {
        return
            new DriverLinkerWithOutputFactory(
                driverLinkerFactory: $driverLinkerFactory ?? $this->getDriverLinkerFactoryMock(),
                output: $output ?? $this->getOutputMock(),
            );
    }

    private function getDriverLinkerFactoryMock(): MockObject&IDriverLinkerFactory
    {
        return $this->createMock(IDriverLinkerFactory::class);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
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

        self::assertInstanceOf(DriverLinkerWithOutput::class, $linker);
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }
}
