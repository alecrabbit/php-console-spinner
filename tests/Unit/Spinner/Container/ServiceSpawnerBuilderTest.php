<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawnerBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

final class ServiceSpawnerBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spawnerBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawnerBuilder::class, $spawnerBuilder);
    }

    protected function getTesteeInstance(?ContainerInterface $container = null): IServiceSpawnerBuilder
    {
        return
            new ServiceSpawnerBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $spawnerBuilder = $this->getTesteeInstance();

        $spawner = $spawnerBuilder
            ->withContainer($this->getContainerMock())
            ->build()
        ;

        self::assertInstanceOf(ServiceSpawner::class, $spawner);
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function throwsIfContainerIsNotSet(): void
    {
        $spawnerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Container is not set.');

        $spawnerBuilder->build();
    }
}
