<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Container\A\Override\AContainerEnclosureOverride;
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

    private function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    protected static function extractContainer(): mixed
    {
        return self::callMethod(AContainerEnclosureOverride::class, self::GET_CONTAINER);
    }

    #[Test]
    public function throwsExceptionWhenContainerIsNotSet(): void
    {
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Container is not set.');

        self::extractContainer();
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
