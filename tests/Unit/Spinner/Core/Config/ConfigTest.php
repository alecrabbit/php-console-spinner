<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class ConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(Config::class, $config);
    }

    protected function getTesteeInstance(): IConfig
    {
        return
            new Config();
    }

    #[Test]
    public function canSetAndGetAuxConfig(): void
    {
        $config = $this->getTesteeInstance();

        $auxConfig = $this->getAuxConfigMock();
        $auxConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IAuxConfig::class)
        ;

        $config->set($auxConfig);

        self::assertSame($auxConfig, $config->get(IAuxConfig::class));
    }

    protected function getAuxConfigMock(): MockObject&IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }

    #[Test]
    public function canSetAndGetLinkerConfig(): void
    {
        $config = $this->getTesteeInstance();

        $linkerConfig = $this->getLinkerConfigMock();
        $linkerConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(ILinkerConfig::class)
        ;

        $config->set($linkerConfig);

        self::assertSame($linkerConfig, $config->get(ILinkerConfig::class));
    }

    protected function getLinkerConfigMock(): MockObject&ILinkerConfig
    {
        return $this->createMock(ILinkerConfig::class);
    }


    #[Test]
    public function canSetAndGetLoopConfig(): void
    {
        $config = $this->getTesteeInstance();

        $loopConfig = $this->getLoopConfigMock();
        $loopConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(ILoopConfig::class)
        ;

        $config->set($loopConfig);

        self::assertSame($loopConfig, $config->get(ILoopConfig::class));
    }


    protected function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

    #[Test]
    public function canSetAndGetOutputConfig(): void
    {
        $config = $this->getTesteeInstance();

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IOutputConfig::class)
        ;

        $config->set($outputConfig);

        self::assertSame($outputConfig, $config->get(IOutputConfig::class));
    }

    protected function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    #[Test]
    public function canSetAndGetWidgetConfig(): void
    {
        $config = $this->getTesteeInstance();

        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IWidgetConfig::class)
        ;

        $config->set($widgetConfig);

        self::assertSame($widgetConfig, $config->get(IWidgetConfig::class));
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    public function canSetAndGetRootWidgetConfig(): void
    {
        $config = $this->getTesteeInstance();

        $rootWidgetConfig = $this->getWidgetConfigMock();
        $rootWidgetConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IRootWidgetConfig::class)
        ;

        $config->set($rootWidgetConfig);

        self::assertSame($rootWidgetConfig, $config->get(IRootWidgetConfig::class));
    }


    #[Test]
    public function throwsIfIdentifierIsNotSet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig" is not set.');

        $element = $config->get(ILoopConfig::class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnSet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "invalid" is not an interface.');

        $object = new class implements IConfigElement {
            public function getIdentifier(): string
            {
                return 'invalid';
            }
        };

        $config->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotAnInterfaceOnSet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $object = new class implements IConfigElement {
            public function getIdentifier(): string
            {
                return stdClass::class;
            }
        };

        $config->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnSet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Settings\Contract\ISettings" is not an instance of'
            . ' "AlecRabbit\Spinner\Core\Config\Contract\IConfigElement".'
        );

        $object = new class implements IConfigElement {
            public function getIdentifier(): string
            {
                return ISettings::class;
            }
        };

        $config->set($object);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnGet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "invalid" is not an interface.');

        $config->get('invalid');

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNoAnInterfaceOnGet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $config->get(stdClass::class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnGet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Settings\Contract\ISettings" is not an instance of'
            . ' "AlecRabbit\Spinner\Core\Config\Contract\IConfigElement".'
        );

        $config->get(ISettings::class);

        self::fail('Exception was not thrown.');
    }
}
