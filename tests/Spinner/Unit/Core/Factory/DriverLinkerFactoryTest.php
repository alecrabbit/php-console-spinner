<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Driver\DriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Driver\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\ILinkerResolver;
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
        ?ILinkerResolver $linkerResolver = null,
    ): IDriverLinkerFactory {
        return
            new DriverLinkerFactory(
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
                linkerResolver: $linkerResolver ?? $this->getLinkerResolverMock(),
            );
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    private function getLinkerResolverMock(): MockObject&ILinkerResolver
    {
        return $this->createMock(ILinkerResolver::class);
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

        $linkerResolver = $this->getLinkerResolverMock();
        $linkerResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                linkerResolver: $linkerResolver,
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

        $linkerResolver = $this->getLinkerResolverMock();
        $linkerResolver
            ->expects(self::never())
            ->method('isEnabled')
        ;

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                linkerResolver: $linkerResolver,
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

        $linkerResolver = $this->getLinkerResolverMock();
        $linkerResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(false)
        ;

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                linkerResolver: $linkerResolver,
            );

        self::assertInstanceOf(DriverLinkerFactory::class, $factory);

        $linker = $factory->create();

        self::assertInstanceOf(DummyDriverLinker::class, $linker);

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('getInterval')
        ;

        $linker->link($driver);
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

    private function getDriverModeDetectorMock(): MockObject&IDriverModeDetector
    {
        return $this->createMock(IDriverModeDetector::class);
    }
}
