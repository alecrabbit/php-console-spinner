<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\A;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\Spinner\Unit\Container\A\Override\AContainerEnclosureOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

final class AContainerEnclosureTest extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
    private const USE_CONTAINER = 'useContainer';
    private static ?ContainerInterface $container;

    protected static function extractContainer(): mixed
    {
        return self::callMethod(AContainerEnclosureOverride::class, self::GET_CONTAINER);
    }

    #[Test]
    public function canUseContainerFactory(): void
    {
        $factoryClass = $this->getContainerFactoryMock();

        AContainerEnclosure::useContainerFactory($factoryClass::class);

        self::assertInstanceOf(IContainer::class, self::extractContainer());
    }

    private function getContainerFactoryMock(): MockObject&IContainerFactory
    {
        return $this->createMock(IContainerFactory::class);
    }

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(null);
        parent::setUp();
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        // FIXME (2023-11-23 17:27) [Alec Rabbit]: to set container call `useContainerFactory` instead
        self::callMethod(AContainerEnclosureOverride::class, self::USE_CONTAINER, $container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
