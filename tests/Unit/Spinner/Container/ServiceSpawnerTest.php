<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceObjectFactory;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\SpawnFailed;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Container\Override\ClassForSpawner;
use AlecRabbit\Tests\Unit\Spinner\Container\Override\ClassForSpawnerWithParameters;
use AlecRabbit\Tests\Unit\Spinner\Container\Override\ClassForSpawnerWithParametersNoType;
use AlecRabbit\Tests\Unit\Spinner\Container\Override\NonInstantiableClass;
use Exception;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

final class ServiceSpawnerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);
    }

    protected function getTesteeInstance(
        ?ContainerInterface $container = null,
        ?ICircularDependencyDetector $circularDependencyDetector = null,
        ?IServiceObjectFactory $serviceObjectFactory = null,
    ): IServiceSpawner {
        return
            new ServiceSpawner(
                container: $container ?? $this->getContainerMock(),
                circularDependencyDetector: $circularDependencyDetector ?? $this->getCircularDependencyDetectorMock(),
                serviceObjectFactory: $serviceObjectFactory ?? $this->getServiceObjectFactoryMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
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
    public function canSpawnObject(): void
    {
        $id = 'id';
        $object =
            new class() {
            };

        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects(self::once())
            ->method('create')
            ->with(
                value: self::identicalTo($object),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects(self::once())
            ->method('getId')
            ->willReturn($id)
        ;
        $serviceDefinition
            ->expects(self::once())
            ->method('getDefinition')
            ->willReturn($object)
        ;

        $serviceObject = $spawner->spawn($serviceDefinition);

        self::assertSame($service, $serviceObject);
    }

    private function getServiceMock(): MockObject&IService
    {
        return $this->createMock(IService::class);
    }

    private function getServiceDefinitionMock(): MockObject&IServiceDefinition
    {
        return $this->createMock(IServiceDefinition::class);
    }

    #[Test]
    public function canSpawnWithClassString(): void
    {
        $classString = ClassForSpawner::class;

        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects(self::once())
            ->method('create')
            ->with(
                value: self::isInstanceOf(ClassForSpawner::class),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects(self::once())
            ->method('getId')
            ->willReturn($classString)
        ;
        $serviceDefinition
            ->expects(self::once())
            ->method('getDefinition')
            ->willReturn($classString)
        ;

        $serviceObject = $spawner->spawn($serviceDefinition);

        self::assertSame($service, $serviceObject);
    }

    #[Test]
    public function canSpawnWithCallable(): void
    {
        $callable = static fn(ContainerInterface $container) => new ClassForSpawner();
        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects(self::once())
            ->method('create')
            ->with(
                value: self::isInstanceOf(ClassForSpawner::class),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects(self::once())
            ->method('getId')
            ->willReturn(ClassForSpawner::class)
        ;
        $serviceDefinition
            ->expects(self::once())
            ->method('getDefinition')
            ->willReturn($callable)
        ;

        $serviceObject = $spawner->spawn($serviceDefinition);

        self::assertSame($service, $serviceObject);
    }

    #[Test]
    public function canSpawnWithClassStringForClassConstructorWithParameters(): void
    {
        $container = $this->getContainerMock();
        $container
            ->expects(self::once())
            ->method('get')
            ->with(ClassForSpawner::class)
            ->willReturn(new ClassForSpawner())
        ;

        $classString = ClassForSpawnerWithParameters::class;

        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects(self::once())
            ->method('create')
            ->with(
                value: self::isInstanceOf($classString),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            container: $container,
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects(self::once())
            ->method('getId')
            ->willReturn(ClassForSpawner::class)
        ;
        $serviceDefinition
            ->expects(self::once())
            ->method('getDefinition')
            ->willReturn($classString)
        ;

        $serviceObject = $spawner->spawn($serviceDefinition);

        self::assertSame($service, $serviceObject);
    }

    #[Test]
    public function throwsSpawnWithClassStringIfClassDoesNotExist(): void
    {
        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = 'Class does not exist: NonExistentClassForSpawner';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $classString = 'NonExistentClassForSpawner';

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);

        $serviceDefinition = new ServiceDefinition(
            id: 'id',
            definition: $classString,
        );

        $spawner->spawn($serviceDefinition);

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }

    #[Test]
    public function throwsWhenConstructorParameterTypeCanNotBeExtracted(): void
    {
        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = 'Unable to extract type for parameter name:';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $classString = ClassForSpawnerWithParametersNoType::class;

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);

        $serviceDefinition = new ServiceDefinition(
            id: 'id',
            definition: $classString,
        );

        $spawner->spawn($serviceDefinition);

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }

    #[Test]
    public function throwsWhenUnableToSpawnByConstructor(): void
    {
        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = 'Unable to create instance of';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $classString = NonInstantiableClass::class;

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);

        $serviceDefinition = new ServiceDefinition(
            id: 'id',
            definition: $classString,
        );

        $spawner->spawn($serviceDefinition);

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }

    #[Test]
    public function throwsWhenUnableToSpawnByCallable(): void
    {
        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = 'Failed to spawn service with id "id".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);

        $serviceDefinition = new ServiceDefinition(
            id: 'id',
            definition: fn() => throw new Exception('Intentional Error.'),
        );

        $spawner->spawn($serviceDefinition);

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }
}
