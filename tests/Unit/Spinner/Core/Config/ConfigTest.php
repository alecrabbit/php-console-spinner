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
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

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

//    #[Test]
//    public function canGetAuxConfig(): void
//    {
//        $auxConfig = $this->getAuxConfigMock();
//
//        $config = $this->getTesteeInstance(
//            auxConfig: $auxConfig,
//        );
//
//        self::assertSame($auxConfig, $config->getAuxConfig());
//    }

    protected function getAuxConfigMock(): IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }

//    #[Test]
//    public function canGetLoopConfig(): void
//    {
//        $loopConfig = $this->getLoopConfigMock();
//
//        $config = $this->getTesteeInstance(
//            loopConfig: $loopConfig,
//        );
//
//        self::assertSame($loopConfig, $config->getLoopConfig());
//    }

    protected function getLoopConfigMock(): ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

//    #[Test]
//    public function canGetOutputConfig(): void
//    {
//        $outputConfig = $this->getOutputConfigMock();
//
//        $config = $this->getTesteeInstance(
//            outputConfig: $outputConfig,
//        );
//
//        self::assertSame($outputConfig, $config->getOutputConfig());
//    }

    protected function getOutputConfigMock(): IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    #[Test]
//    public function canGetDriverConfig(): void
//    {
//        $driverConfig = $this->getDriverConfigMock();
//
//        $config = $this->getTesteeInstance(
//            driverConfig: $driverConfig,
//        );
//
//        self::assertSame($driverConfig, $config->getDriverConfig());
//    }

    protected function getDriverConfigMock(): IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

//    #[Test]
//    public function canGetWidgetConfig(): void
//    {
//        $widgetConfig = $this->getWidgetConfigMock();
//
//        $config = $this->getTesteeInstance(
//            widgetConfig: $widgetConfig,
//        );
//
//        self::assertSame($widgetConfig, $config->getWidgetConfig());
//        self::assertNotSame($widgetConfig, $config->getRootWidgetConfig());
//    }

    protected function getWidgetConfigMock(): IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

//    #[Test]
//    public function canGetRootWidgetConfig(): void
//    {
//        $rootWidgetConfig = $this->getWidgetConfigMock();
//
//        $config = $this->getTesteeInstance(
//            rootWidgetConfig: $rootWidgetConfig,
//        );
//
//        self::assertSame($rootWidgetConfig, $config->getRootWidgetConfig());
//        self::assertNotSame($rootWidgetConfig, $config->getWidgetConfig());
//    }

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
                return \stdClass::class;
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

        $config->get(\stdClass::class);

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
