<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Facade;

abstract class FacadeAwareTestCase extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
    private const SET_CONTAINER = 'setContainer';
    private static ?IContainer $container = null;

    protected static function getStoredContainer(): ?IContainer
    {
        return self::$container;
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::storeContainer();
        self::setTestContainer();
    }

    protected static function storeContainer(): void
    {
        self::$container = self::extractContainer();
    }

    protected static function extractContainer(): mixed
    {
        return self::callMethod(Facade::class, self::GET_CONTAINER);
    }

    protected static function setTestContainer(): void
    {
        self::setContainer(null);
    }

    protected static function setContainer(?IContainer $container): void
    {
        self::callMethod(Facade::class, self::SET_CONTAINER, $container);
    }

    protected function tearDown(): void
    {
        self::rollbackContainer();
        parent::tearDown();
    }

    protected static function rollbackContainer(): void
    {
        self::setContainer(self::$container);
    }
}
