<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;

abstract class FacadeAwareTestCase extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
    private const CONFIGURATION_CREATED = 'configurationCreated';
    private static ?ContainerInterface $container;
    private static ?bool $configurationCreated;

    protected static function getStoredContainer(): ?ContainerInterface
    {
        return self::$container;
    }

    protected function setUp(): void
    {
        self::$container = self::getFacadeContainer();
        self::setContainer(null);
        self::$configurationCreated = self::extractConfigurationCreated();
        self::setConfigurationCreated(false);
        parent::setUp();
    }

    protected static function getFacadeContainer(): mixed
    {
        return self::callMethod(Facade::class, self::GET_CONTAINER);
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        Facade::useContainer($container);
    }

    protected static function extractConfigurationCreated(): mixed
    {
        return self::getPropertyValue(self::CONFIGURATION_CREATED, Facade::class);
    }

    protected static function setConfigurationCreated(bool $configurationCreated): void
    {
        self::setPropertyValue(Facade::class, self::CONFIGURATION_CREATED, $configurationCreated);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
        self::setConfigurationCreated(self::$configurationCreated);
    }
}
