<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Spinner\Unit\Container\A\Override\AContainerEnclosureOverride;
use Psr\Container\ContainerInterface;

abstract class FacadeAwareTestCase extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
    private const USE_CONTAINER = 'useContainer';
    private static ?ContainerInterface $container;

    protected static function getStoredContainer(): ?ContainerInterface
    {
        return self::$container;
    }

    protected function setUp(): void
    {
        self::$container = self::getFacadeContainer();
        self::setContainer(null);
        parent::setUp();
    }

    protected static function getFacadeContainer(): mixed
    {
        return self::callMethod(Facade::class, self::GET_CONTAINER);
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        // FIXME (2023-11-23 17:27) [Alec Rabbit]: to set container call `useContainerFactory` instead
        self::callMethod(Facade::class, self::USE_CONTAINER, $container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
