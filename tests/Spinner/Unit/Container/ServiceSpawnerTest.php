<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IInvokableFactory;
use AlecRabbit\Spinner\Container\Contract\IReference;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceFactory;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\SpawnFailed;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Tests\Spinner\Unit\Container\Override\ClassForSpawner;
use AlecRabbit\Tests\Spinner\Unit\Container\Override\ClassForSpawnerTwo;
use AlecRabbit\Tests\Spinner\Unit\Container\Override\ClassForSpawnerUnionNotAllowingNull;
use AlecRabbit\Tests\Spinner\Unit\Container\Override\ClassForSpawnerWithParameters;
use AlecRabbit\Tests\Spinner\Unit\Container\Override\ClassForSpawnerWithParametersNoType;
use AlecRabbit\Tests\Spinner\Unit\Container\Override\NonInstantiableClass;
use AlecRabbit\Tests\TestCase\TestCase;
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
        ?IServiceFactory $serviceObjectFactory = null,
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

    private function getServiceObjectFactoryMock(): MockObject&IServiceFactory
    {
        return $this->createMock(IServiceFactory::class);
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
            ->expects($this->once())
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
            ->expects($this->once())
            ->method('getId')
            ->willReturn($id)
        ;
        $serviceDefinition
            ->expects($this->once())
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
    public function canSpawnByReference(): void
    {
        $id = 'id';
        $reference = $this->getReferenceMock();
        $reference
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($id)
        ;

        $container = $this->getContainerMock();
        $service = $this->getServiceMock();

        $factory = $this->getInvokableFactoryMock();
        $factory
            ->expects($this->once())
            ->method('__invoke')
            ->with()
            ->willReturn($service)
        ;

        $container
            ->expects($this->once())
            ->method('get')
            ->with($id)
            ->willReturn($factory)
        ;

        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                value: self::identicalTo($service),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            container: $container,
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects($this->once())
            ->method('getId')
            ->willReturn($id)
        ;
        $serviceDefinition
            ->expects($this->once())
            ->method('getDefinition')
            ->willReturn($reference)
        ;

        $serviceObject = $spawner->spawn($serviceDefinition);

        self::assertSame($service, $serviceObject);
    }

    private function getReferenceMock(): MockObject&IReference
    {
        return $this->createMock(IReference::class);
    }

    private function getInvokableFactoryMock(): MockObject&IInvokableFactory
    {
        return $this->createMock(IInvokableFactory::class);
    }

    #[Test]
    public function canSpawnWithClassString(): void
    {
        $classString = ClassForSpawner::class;

        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                value: self::isInstanceOf($classString),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects($this->once())
            ->method('getId')
            ->willReturn($classString)
        ;
        $serviceDefinition
            ->expects($this->once())
            ->method('getDefinition')
            ->willReturn($classString)
        ;

        $serviceObject = $spawner->spawn($serviceDefinition);

        self::assertSame($service, $serviceObject);
    }

    #[Test]
    public function canSpawnWithClassStringTwo(): void
    {
        $classString = ClassForSpawnerTwo::class;

        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                value: self::isInstanceOf($classString),
                serviceDefinition: $serviceDefinition,
            )
            ->willReturn($service)
        ;

        $spawner = $this->getTesteeInstance(
            serviceObjectFactory: $serviceObjectFactory,
        );

        $serviceDefinition
            ->expects($this->once())
            ->method('getId')
            ->willReturn($classString)
        ;
        $serviceDefinition
            ->expects($this->once())
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
            ->expects($this->once())
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
            ->expects($this->once())
            ->method('getId')
            ->willReturn(ClassForSpawner::class)
        ;
        $serviceDefinition
            ->expects($this->once())
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
            ->expects($this->once())
            ->method('get')
            ->with(ClassForSpawner::class)
            ->willReturn(new ClassForSpawner())
        ;

        $classString = ClassForSpawnerWithParameters::class;

        $service = $this->getServiceMock();
        $serviceDefinition = $this->getServiceDefinitionMock();

        $serviceObjectFactory = $this->getServiceObjectFactoryMock();
        $serviceObjectFactory
            ->expects($this->once())
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
            ->expects($this->once())
            ->method('getId')
            ->willReturn(ClassForSpawner::class)
        ;
        $serviceDefinition
            ->expects($this->once())
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
    public function throwsWhenUnableToSpawnByConstructorTwo(): void
    {
        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = 'Only "ReflectionNamedType" parameters are supported without default value.';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $classString = ClassForSpawnerUnionNotAllowingNull::class;

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

    #[Test]
    public function throwsWhenReferenceIsNotInvokable(): void
    {
        $id = 'id';
        $factoryId = 'factory';

        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = sprintf(
            'Failed to spawn service with id "%s". [%s]: "Service with id "%s" is not invokable.".',
            $id,
            SpawnFailed::class,
            $factoryId,
        );

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);


        $reference = $this->getReferenceMock();
        $reference
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($factoryId)
        ;

        $container = $this->getContainerMock();
        $container
            ->expects($this->once())
            ->method('get')
            ->with($factoryId)
            ->willReturn(new ClassForSpawner())
        ;

        $serviceDefinition = $this->getServiceDefinitionMock();
        $serviceDefinition
            ->expects($this->exactly(2))
            ->method('getId')
            ->willReturn($id)
        ;
        $serviceDefinition
            ->expects($this->once())
            ->method('getDefinition')
            ->willReturn($reference)
        ;

        $spawner = $this->getTesteeInstance(container: $container);

        $spawner->spawn($serviceDefinition);

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }
}
