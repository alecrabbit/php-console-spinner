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
    private static ?ContainerInterface $container;

    #[Test]
    public function canUseContainer(): void
    {
        $container = $this->getContainerMock();
        AContainerEnclosure::useContainer($container);

        self::assertSame($container, self::extractContainer());
    }

    private function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

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

    #[Test]
    public function canUseContainerAdapter(): void
    {
        $container = $this->getContainerInterfaceMock();
        AContainerEnclosure::useContainer($container);

        $extractedContainer = self::extractContainer();

        self::assertInstanceOf(ContainerAdapter::class, $extractedContainer);
        self::assertSame($container, self::getPropertyValue('container', $extractedContainer));
    }

    private function getContainerInterfaceMock(): MockObject&ContainerInterface
    {
        return $this->createMock(ContainerInterface::class);
    }

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(null);
        parent::setUp();
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        AContainerEnclosure::useContainer($container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
