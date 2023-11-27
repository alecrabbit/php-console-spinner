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
    public function canUseContainerFactoryClass(): void
    {
        $factoryClass = $this->getContainerFactoryMock();

        AContainerEnclosure::useContainerFactory($factoryClass::class);

        self::assertInstanceOf(IContainer::class, self::extractContainer());
    }

    #[Test]
    public function throwsIfFactoryClassISInvalid(): void
    {
        $class = \stdClass::class;
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Factory class must implement [%s]. "%s" given.',
                IContainerFactory::class,
                $class,
            )
        );
        AContainerEnclosure::useContainerFactory($class);
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
        self::callMethod(AContainerEnclosureOverride::class, self::USE_CONTAINER, $container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
