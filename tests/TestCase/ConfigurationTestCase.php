<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

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

    protected function setUp(): void
    {
        self::removeOtherContainerFactories();
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
        self::setFactories(self::$factories);
    }
}
