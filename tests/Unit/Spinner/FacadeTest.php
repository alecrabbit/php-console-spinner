<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

final class FacadeTest extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
    private static ?ContainerInterface $container;

//    #[Test]
//    public function canNotBeInstantiated(): void
//    {
//        $this->expectException(\Error::class);
//        $this->expectExceptionMessage('Call to private AlecRabbit\Spinner\Facade::__construct()');
//        $facade = new Facade();
//    }

    #[Test]
    public function canGetSettings(): void
    {
        $container = $this->getContainerMock();
        self::setContainer($container);

        $settings = $this->getSettingsMock();

        $settingsProvider = $this->getSettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getUserSettings')
            ->willReturn($settings)
        ;

        $container
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ISettingsProvider::class))
            ->willReturn($settingsProvider)
        ;

        self::assertSame($settings, Facade::getSettings());
    }

    private function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        Facade::setContainer($container);
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }

    private function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

    #[Test]
    public function canGetLoop(): void
    {
        $container = $this->getContainerMock();
        self::setContainer($container);

        $loop = $this->getLoopMock();

        $loopProvider = $this->getLoopProviderMock();
        $loopProvider
            ->expects(self::once())
            ->method('getLoop')
            ->willReturn($loop)
        ;

        $container
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILoopProvider::class))
            ->willReturn($loopProvider)
        ;

        self::assertSame($loop, Facade::getLoop());
    }

    private function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    #[Test]
    public function canCreateSpinner(): void
    {
        $container = $this->getContainerMock();
        self::setContainer($container);

        $spinner = $this->getSpinnerMock();

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('add')
            ->with(self::identicalTo($spinner))
        ;

        $driverProvider = $this->getDriverProviderMock();
        $driverProvider
            ->expects(self::once())
            ->method('getDriver')
            ->willReturn($driver)
        ;

        $spinnerSettings = $this->getSpinnerSettingsMock();
        $spinnerSettings
            ->expects(self::once())
            ->method('isAutoAttach')
            ->willReturn(true)
        ;

        $spinnerFactory = $this->getSpinnerFactoryMock();
        $spinnerFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($spinnerSettings))
            ->willReturn($spinner)
        ;

        $container
            ->method('get')
            ->willReturnOnConsecutiveCalls($spinnerFactory, $driverProvider)
        ;


        self::assertSame($spinner, Facade::createSpinner($spinnerSettings));
    }

    private function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getDriverProviderMock(): MockObject&IDriverProvider
    {
        return $this->createMock(IDriverProvider::class);
    }

    private function getSpinnerSettingsMock(): MockObject&ISpinnerSettings
    {
        return $this->createMock(ISpinnerSettings::class);
    }

    private function getSpinnerFactoryMock(): MockObject&ISpinnerFactory
    {
        return $this->createMock(ISpinnerFactory::class);
    }

    #[Test]
    public function canGetDriver(): void
    {
        $container = $this->getContainerMock();
        self::setContainer($container);

        $driver = $this->getDriverMock();

        $driverProvider = $this->getDriverProviderMock();
        $driverProvider
            ->expects(self::once())
            ->method('getDriver')
            ->willReturn($driver)
        ;

        $container
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IDriverProvider::class))
            ->willReturn($driverProvider)
        ;

        self::assertSame($driver, Facade::getDriver());
    }

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(null);
        parent::setUp();
    }

    protected static function extractContainer(): mixed
    {
        return self::callMethod(Facade::class, self::GET_CONTAINER);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
