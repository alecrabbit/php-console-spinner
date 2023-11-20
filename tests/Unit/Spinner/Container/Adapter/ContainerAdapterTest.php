<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container\Adapter;


use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

final class ContainerAdapterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $adapter = $this->getTesteeInstance();

        self::assertInstanceOf(ContainerAdapter::class, $adapter);
    }

    private function getTesteeInstance(
        ?ContainerInterface $container = null,
    ): IContainer {
        return new ContainerAdapter($container ?? $this->getContainerMock());
    }

    private function getContainerMock(): MockObject&ContainerInterface
    {
        return $this->createMock(ContainerInterface::class);
    }

    #[Test]
    public function canGet(): void
    {
        $id = 'id';

        $container = $this->getContainerMock();
        $service = new \stdClass();

        $container
            ->expects(self::once())
            ->method('get')
            ->with($id)
            ->willReturn($service)
        ;
        $container
            ->expects(self::never())
            ->method('has')
        ;

        $adapter = $this->getTesteeInstance($container);

        self::assertSame($service, $adapter->get($id));
    }

    #[Test]
    public function canHas(): void
    {
        $id = 'id';

        $container = $this->getContainerMock();

        $container
            ->expects(self::once())
            ->method('has')
            ->with($id)
            ->willReturn(true)
        ;
        $container
            ->expects(self::never())
            ->method('get')
        ;

        $adapter = $this->getTesteeInstance($container);

        self::assertTrue($adapter->has($id));
    }
}
