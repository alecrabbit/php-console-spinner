<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\ClassDoesNotExist;
use AlecRabbit\Spinner\Container\Exception\SpawnFailedException;
use AlecRabbit\Spinner\Container\Exception\UnableToCreateInstance;
use AlecRabbit\Spinner\Container\Exception\UnableToExtractType;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override\ClassForSpawner;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override\ClassForSpawnerWithParameters;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override\ClassForSpawnerWithParametersNoType;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override\NonInstantiableClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Container\ContainerInterface;

final class ServiceSpawnerTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
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

    #[Test]
    public function canSpawnObject(): void
    {
        $object = new class {
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
        $callable = fn() => new ClassForSpawner();

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
            ->willReturn(new ClassForSpawner());

        $classString = ClassForSpawnerWithParameters::class;

        $spawner = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ServiceSpawner::class, $spawner);
        self::assertInstanceOf(ClassForSpawnerWithParameters::class, $spawner->spawn($classString));
    }

    #[Test]
    public function throwsSpawnWithClassStringIfClassDoesNotExist(): void
    {
        $exceptionClass = SpawnFailedException::class;
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
        $exceptionClass = SpawnFailedException::class;
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
    public function throwsWhenUnableToSpawn(): void
    {
        $exceptionClass = SpawnFailedException::class;
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
}
