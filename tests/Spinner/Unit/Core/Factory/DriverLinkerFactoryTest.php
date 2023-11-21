<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverLinkerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $linkerSingletonFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerFactory::class, $linkerSingletonFactory);
    }

    public function getTesteeInstance(
        ?ILoopProvider $loopProvider = null,
        ?ILinkerConfig $linkerConfig = null,
    ): IDriverLinkerFactory {
        return
            new DriverLinkerFactory(
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
                linkerConfig: $linkerConfig ?? $this->getLinkerConfigMock(),
            );
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    private function getLinkerConfigMock(?LinkerMode $linkerMode = null): MockObject&ILinkerConfig
    {
        return $this->createConfiguredMock(
            ILinkerConfig::class,
            [
                'getLinkerMode' => $linkerMode ?? LinkerMode::DISABLED,
            ]
        );
    }

    #[Test]
    public function canCreateLinker(): void
    {
        $loopProvider = $this->getLoopProviderMock();
        $loopProvider
            ->expects(self::once())
            ->method('hasLoop')
            ->willReturn(true)
        ;

        $linkerConfig = $this->getLinkerConfigMock(LinkerMode::ENABLED);

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                linkerConfig: $linkerConfig
            );

        self::assertInstanceOf(DriverLinkerFactory::class, $factory);
        self::assertInstanceOf(DriverLinker::class, $factory->create());
    }

    #[Test]
    public function canCreateDummyLinkerCaseOne(): void
    {
        $loopProvider = $this->getLoopProviderMock();
        $loopProvider
            ->expects(self::once())
            ->method('hasLoop')
            ->willReturn(false)
        ;

        $linkerConfig = $this->getLinkerConfigMock();
        $linkerConfig
            ->expects(self::never())
            ->method('getLinkerMode')
            ->willReturn(LinkerMode::ENABLED)
        ;

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                linkerConfig: $linkerConfig
            );

        self::assertInstanceOf(DriverLinkerFactory::class, $factory);

        $linker = $factory->create();

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('getInterval')
        ;

        $linker->link($driver);
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    #[Test]
    public function canCreateDummyLinkerCaseTwo(): void
    {
        $loopProvider = $this->getLoopProviderMock();
        $loopProvider
            ->expects(self::once())
            ->method('hasLoop')
            ->willReturn(true)
        ;

        $linkerConfig = $this->getLinkerConfigMock();
        $linkerConfig
            ->expects(self::once())
            ->method('getLinkerMode')
            ->willReturn(LinkerMode::ENABLED)
        ;

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                linkerConfig: $linkerConfig
            );

        self::assertInstanceOf(DriverLinkerFactory::class, $factory);

        $linker = $factory->create();

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('getInterval')
        ;

        $linker->link($driver);
    }
}
