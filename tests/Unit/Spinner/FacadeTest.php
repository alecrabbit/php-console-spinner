<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
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
