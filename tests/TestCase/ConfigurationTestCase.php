<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Facade;

abstract class ConfigurationTestCase extends ContainerModifyingTestCase
{
    protected static function getRequiredConfig(string $class): IConfigElement
    {
        static::performContainerModifications();
        return self::getConfigProvider()->getConfig()->get($class);
    }

    abstract protected static function performContainerModifications(): void;

    protected static function getConfigProvider(): IConfigProvider
    {
        self::createConfiguration();

        $container = self::extractContainer();

        /** @var IConfigProvider $configProvider */
        $configProvider = $container->get(IConfigProvider::class);

        return $configProvider;
    }

    protected static function createConfiguration(): void
    {
        Facade::createSpinner();
    }
}
