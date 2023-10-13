<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;
use Traversable;

abstract class ConfigurationTestCase extends ContainerModifyingTestCase
{
    protected static function getRequiredConfig(string $class): IConfigElement
    {
        return self::getConfigProvider()->getConfig()->get($class);
    }

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
