<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\ContainerFactoryStore;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IContainerFactoryStore;
use AlecRabbit\Tests\TestCase\Helper\PickLock;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ContainerFactoryStoreTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $store = $this->getTesteeInstance();

        self::assertInstanceOf(ContainerFactoryStore::class, $store);
    }

    private function getTesteeInstance(
        ?\ArrayObject $factories = null,
    ): IContainerFactoryStore
    {
        return
            new ContainerFactoryStore(
                factories: $factories ?? new \ArrayObject(),
            );
    }
    private function getContainerFactoryMock(): MockObject&IContainerFactory
    {
        return $this->createMock(IContainerFactory::class);
    }

    #[Test]
    public function canGetIterator(): void
    {
        $factory01 = $this->getContainerFactoryMock();
        $factory02 = $this->getContainerFactoryMock();

        $factories = [
            $factory01,
            $factory02,
        ];

        $store = $this->getTesteeInstance(
            factories: new \ArrayObject($factories),
        );

        $iterator = $store->getIterator();

        self::assertContains($factory01, $iterator);
        self::assertContains($factory02, $iterator);
    }


    #[Test]
    public function canAddFactory(): void
    {
        $factory01 = $this->getContainerFactoryMock();
        $factory02 = $this->getContainerFactoryMock();

        $store = $this->getTesteeInstance();

        $iterator = $store->getIterator();

        self::assertNotContains($factory01, $iterator);
        self::assertNotContains($factory02, $iterator);

        $store->add($factory01);
        $store->add($factory02);

        $iterator = $store->getIterator();

        self::assertContains($factory01, $iterator);
        self::assertContains($factory02, $iterator);
    }
}
