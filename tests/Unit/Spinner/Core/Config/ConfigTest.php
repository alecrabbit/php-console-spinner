<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class ConfigTest extends TestCaseWithPrebuiltMocksAndStubs
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
            ->expects($this->once())
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
    public function canSetAndGetDriverConfig(): void
    {
        $config = $this->getTesteeInstance();

        $driverConfig = $this->getDriverConfigMock();
        $driverConfig
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn(IDriverConfig::class)
        ;

        $config->set($driverConfig);

        self::assertSame($driverConfig, $config->get(IDriverConfig::class));
    }

    protected function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }


    #[Test]
    public function canSetAndGetLoopConfig(): void
    {
        $config = $this->getTesteeInstance();

        $loopConfig = $this->getLoopConfigMock();
        $loopConfig
            ->expects($this->once())
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
            ->expects($this->once())
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
            ->expects($this->once())
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
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn(IRootWidgetConfig::class)
        ;

        $config->set($rootWidgetConfig);

        self::assertSame($rootWidgetConfig, $config->get(IRootWidgetConfig::class));
    }


    #[Test]
    public function returnsNullIfIdentifierIsNotSet(): void
    {
        $config = $this->getTesteeInstance();

        self::assertNull($config->get(ILoopConfig::class));
    }

    #[Test]
    public function throwIfIdentifierIsInvalidOnSet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
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

        $this->expectException(InvalidArgumentException::class);
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

        $this->expectException(InvalidArgumentException::class);
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

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier "invalid" is not an interface.');

        $config->get('invalid');

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNoAnInterfaceOnGet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier "stdClass" is not an interface.');

        $config->get(stdClass::class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfIdentifierIsNotSettingsElementOnGet(): void
    {
        $config = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Identifier "AlecRabbit\Spinner\Core\Settings\Contract\ISettings" is not an instance of'
            . ' "AlecRabbit\Spinner\Core\Config\Contract\IConfigElement".'
        );

        $config->get(ISettings::class);

        self::fail('Exception was not thrown.');
    }
}
