<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlingSetupFactory;
use AlecRabbit\Spinner\Core\Factory\SignalHandlingSetupFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\SignalHandlingSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SignalHandlingSetupFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $linkerSingletonFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlingSetupFactory::class, $linkerSingletonFactory);
    }

    public function getTesteeInstance(
        ?ILoopProvider $loopProvider = null,
        ?ILoopConfig $loopConfig = null,
    ): ISignalHandlingSetupFactory {
        return
            new SignalHandlingSetupFactory(
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
                loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
            );
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    private function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $loopConfig = $this->getLoopConfigMock();
        $loopConfig
            ->expects(self::once())
            ->method('getSignalHandlingMode')
            ->willReturn(SignalHandlingMode::ENABLED)
        ;

        $loopProvider = $this->getLoopProviderMock();
        $loopProvider
            ->expects(self::once())
            ->method('hasLoop')
            ->willReturn(true)
        ;

        $loopProvider
            ->expects(self::once())
            ->method('getLoop')
        ;

        $factory = $this->getTesteeInstance(
            loopProvider: $loopProvider,
            loopConfig: $loopConfig
        );

        $setup = $factory->create();

        self::assertInstanceOf(SignalHandlingSetup::class, $setup);
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

        $loopConfig = $this->getLoopConfigMock();
        $loopConfig
            ->expects(self::never())
            ->method('getSignalHandlingMode')
            ->willReturn(SignalHandlingMode::ENABLED)
        ;

        $factory =
            $this->getTesteeInstance(
                loopProvider: $loopProvider,
                loopConfig: $loopConfig
            );

        self::assertInstanceOf(SignalHandlingSetupFactory::class, $factory);

        $setup = $factory->create();

        $driver = $this->getDriverMock();

        $setup->setup($driver);
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }
}
