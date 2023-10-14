<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;

abstract class ConfigurationTestCase extends ContainerModifyingTestCase
{
    protected static function getRequiredConfig(string $class): IConfigElement
    {
        return
            self::extractConfigProvider(
                self::getFacadeContainer()
            )
                ->getConfig()
                ->get($class)
        ;
    }

    protected static function extractConfigProvider(ContainerInterface $container): IConfigProvider
    {
        return $container->get(IConfigProvider::class);
    }

    abstract protected static function performContainerModifications(): void;

    protected function setUp(): void
    {
        parent::setUp();
        static::performContainerModifications();
    }


}
