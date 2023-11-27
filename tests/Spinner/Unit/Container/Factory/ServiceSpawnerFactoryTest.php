<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Factory;


use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceObjectFactory;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerFactory;
use AlecRabbit\Spinner\Container\Factory\ServiceSpawnerFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ServiceSpawnerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();
        self::assertInstanceOf(ServiceSpawnerFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IServiceSpawnerBuilder $spawnerBuilder = null,
        ?ICircularDependencyDetector $circularDependencyDetector = null,
        ?IServiceObjectFactory $serviceObjectFactory = null,
    ): IServiceSpawnerFactory {
        return
            new ServiceSpawnerFactory(
                spawnerBuilder: $spawnerBuilder ?? $this->getSpawnerBuilderMock(),
                circularDependencyDetector: $circularDependencyDetector ?? $this->getCircularDependencyDetectorMock(),
                serviceObjectFactory: $serviceObjectFactory ?? $this->getServiceObjectFactoryMock(),
            );
    }

    private function getSpawnerBuilderMock(): MockObject&IServiceSpawnerBuilder
    {
        return $this->createMock(IServiceSpawnerBuilder::class);
    }

    private function getCircularDependencyDetectorMock(): MockObject&ICircularDependencyDetector
    {
        return $this->createMock(ICircularDependencyDetector::class);
    }

    private function getServiceObjectFactoryMock(): MockObject&IServiceObjectFactory
    {
        return $this->createMock(IServiceObjectFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $container = $this->getContainerMock();
        $dependencyDetector = $this->getCircularDependencyDetectorMock();
        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceSpawner = $this->createMock(IServiceSpawner::class);

        $builder = $this->getSpawnerBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withContainer')
            ->with($container)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withCircularDependencyDetector')
            ->with($dependencyDetector)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withServiceObjectFactory')
            ->with($serviceObjectFactory)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($serviceSpawner)
        ;

        $factory = $this->getTesteeInstance(
            spawnerBuilder: $builder,
            circularDependencyDetector: $dependencyDetector,
            serviceObjectFactory: $serviceObjectFactory,
        );
        self::assertSame($serviceSpawner, $factory->create($container));
    }

    private function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }
}
