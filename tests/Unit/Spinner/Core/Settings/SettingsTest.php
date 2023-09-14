<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(Settings::class, $settings);
    }

    public function getTesteeInstance(): ISettings
    {
        return
            new Settings();
    }

    #[Test]
    public function canSetAndGetAuxSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $auxSettings = $this->getAuxSettingsMock();
        $auxSettings
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn(IAuxSettings::class)
        ;

        $settings->set($auxSettings);

        self::assertSame($auxSettings, $settings->get(IAuxSettings::class));
    }

    protected function getAuxSettingsMock(): MockObject&IAuxSettings
    {
        return $this->createMock(IAuxSettings::class);
    }

    #[Test]
    public function canGetLoopSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $loopSettings = $this->getLoopSettingsMock();
        $loopSettings
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn(ILoopSettings::class)
        ;

        $settings->set($loopSettings);

        self::assertSame($loopSettings, $settings->get(ILoopSettings::class));
    }

    protected function getLoopSettingsMock(): MockObject&ILoopSettings
    {
        return $this->createMock(ILoopSettings::class);
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnSet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier "invalid" is not an interface.');

        $object = new class implements ISettingsElement {
            public function getIdentifier(): string
            {
                return 'invalid';
            }
        };

        $settings->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotAnInterfaceOnSet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $object = new class implements ISettingsElement {
            public function getIdentifier(): string
            {
                return \stdClass::class;
            }
        };

        $settings->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnSet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Config\Contract\IConfig" is not an instance of '
            . '"AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement".'
        );

        $object = new class implements ISettingsElement {
            public function getIdentifier(): string
            {
                return IConfig::class;
            }
        };

        $settings->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnGet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier "invalid" is not an interface.');

        $settings->get('invalid');

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNoAnInterfaceOnGet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $settings->get(\stdClass::class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnGet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Config\Contract\IConfig" is not an instance of '
            . '"AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement".'
        );

        $settings->get(IConfig::class);

        self::fail('Exception was not thrown.');
    }

    protected function getOutputSettingsMock(): MockObject&IOutputSettings
    {
        return $this->createMock(IOutputSettings::class);
    }

    protected function getDriverSettingsMock(): MockObject&IDriverSettings
    {
        return $this->createMock(IDriverSettings::class);
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }
}
