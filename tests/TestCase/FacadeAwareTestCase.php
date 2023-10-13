<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;

abstract class FacadeAwareTestCase extends TestCase
{
    protected const GET_CONTAINER = 'getContainer';
    protected static ?ContainerInterface $container;
    protected static ?bool $configurationCreated;

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(null);
        self::$configurationCreated = self::extractConfigurationCreated();
        self::setConfigurationCreated(false);
        parent::setUp();
    }

    protected static function extractContainer(): mixed
    {
        return self::callMethod(Facade::class, self::GET_CONTAINER);
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        Facade::setContainer($container);
    }

    protected static function extractConfigurationCreated(): mixed
    {
        return self::getPropertyValue('configurationCreated', Facade::class);
    }

    protected static function setConfigurationCreated(bool $configurationCreated): void
    {
        self::setPropertyValue(Facade::class, 'configurationCreated', $configurationCreated);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
        self::setConfigurationCreated(self::$configurationCreated);
    }
}
