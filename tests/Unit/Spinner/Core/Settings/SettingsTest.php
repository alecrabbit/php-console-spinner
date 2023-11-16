<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class SettingsTest extends TestCase
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
    public function canSetAndGetGeneralSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $auxSettings = $this->getGeneralSettingsMock();
        $auxSettings
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IGeneralSettings::class)
        ;

        $settings->set($auxSettings);

        self::assertSame($auxSettings, $settings->get(IGeneralSettings::class));
    }

    protected function getGeneralSettingsMock(): MockObject&IGeneralSettings
    {
        return $this->createMock(IGeneralSettings::class);
    }

    #[Test]
    public function canGetLoopSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $loopSettings = $this->getLoopSettingsMock();
        $loopSettings
            ->expects(self::once())
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
    public function returnsNullIfIdentifierIsNotSet(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertNull($settings->get(ILoopSettings::class));
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnSet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
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

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $object = new class implements ISettingsElement {
            public function getIdentifier(): string
            {
                return stdClass::class;
            }
        };

        $settings->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnSet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Widget\Contract\IWidget" is not an instance of '
            . '"AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement".'
        );

        $object = new class implements ISettingsElement {
            public function getIdentifier(): string
            {
                return IWidget::class;
            }
        };

        $settings->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnGet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "invalid" is not an interface.');

        $settings->get('invalid');

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNoAnInterfaceOnGet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $settings->get(stdClass::class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnGet(): void
    {
        $settings = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Widget\Contract\IWidget" is not an instance of '
            . '"AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement".'
        );

        $settings->get(IWidget::class);

        self::fail('Exception was not thrown.');
    }

    protected function getOutputSettingsMock(): MockObject&IOutputSettings
    {
        return $this->createMock(IOutputSettings::class);
    }

    protected function getLinkerSettingsMock(): MockObject&ILinkerSettings
    {
        return $this->createMock(ILinkerSettings::class);
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }
}
