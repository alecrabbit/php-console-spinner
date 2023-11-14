<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\SpawnFailed;
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

    protected function getTesteeInstance(?ContainerInterface $container = null): IServiceSpawner
    {
        return new ServiceSpawner(
            container: $container ?? $this->getContainerMock(),
        );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function canSpawnObject(): void
    {
        $object = new class() {
        };

        $spawner = $this->getTesteeInstance();

        self::assertSame($object, $spawner->spawn($object));
        self::assertInstanceOf(ServiceSpawner::class, $spawner);
    }

    #[Test]
    public function canSpawnWithClassString(): void
    {
        $classString = ClassForSpawner::class;

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);
        self::assertInstanceOf(ClassForSpawner::class, $spawner->spawn($classString));
    }

    #[Test]
    public function canSpawnWithCallable(): void
    {
        $callable = static fn(ContainerInterface $container) => new ClassForSpawner();

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);
        self::assertInstanceOf(ClassForSpawner::class, $spawner->spawn($callable));
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

        $spawner = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ServiceSpawner::class, $spawner);
        self::assertInstanceOf(ClassForSpawnerWithParameters::class, $spawner->spawn($classString));
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

        $spawner->spawn($classString);

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

        $spawner->spawn($classString);

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

        $spawner->spawn($classString);

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }

    #[Test]
    public function throwsWhenUnableToSpawnByCallable(): void
    {
        $exceptionClass = SpawnFailed::class;
        $exceptionMessage = 'Could not spawn service.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $spawner = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceSpawner::class, $spawner);

        $spawner->spawn(fn() => throw new Exception('Intentional Error.'));

        self::fail(
            self::exceptionNotThrownString($exceptionClass, $exceptionMessage)
        );
    }
}
