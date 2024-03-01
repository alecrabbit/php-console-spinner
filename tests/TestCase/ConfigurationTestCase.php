<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\DI\ContainerFactories;
use RuntimeException;

abstract class ConfigurationTestCase extends ContainerModifyingTestCase
{
    private static $factories = [];

    protected static function getRequiredConfig(string $class): IConfigElement
    {
        $config = self::getService($class);
        if ($config instanceof IConfigElement && is_a($config, $class, true)) {
            return $config;
        }
        throw new RuntimeException('Unable to get required config: ' . $class);
    }

    protected static function getService(string $id): mixed
    {
        $container = self::getCurrentContainer();
        if($container instanceof ContainerAdapter) {
            dump(get_class(self::getPropertyValue('container', $container)));
        } else {
            dump(get_class($container));
        }
        return $container->get($id);
    }

    protected function setUp(): void
    {
//        self::removeOtherContainerFactories();
        parent::setUp();
    }

    private static function removeOtherContainerFactories(): void
    {
        self::$factories = self::extractFactories();
        self::setFactories([ContainerFactory::class]);
    }

    protected static function extractFactories(): mixed
    {
        return self::getPropertyValue('factories', ContainerFactories::class);
    }

    private static function setFactories(array $array): void
    {
        self::setPropertyValue(ContainerFactories::class, 'factories', $array,);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
//        self::setFactories(self::$factories);
    }
}
