<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;

abstract class FacadeAwareTestCase extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
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
        Facade::useContainer($container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
