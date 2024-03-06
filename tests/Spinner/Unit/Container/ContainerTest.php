<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\SpawnFailed;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Tests\Spinner\Unit\Container\Stub\NonInstantiableClass;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;
use Traversable;

final class ContainerTest extends TestCase
{
    #[Test]
    public function canBeInstantiatedWithNullDefinitions(): void
    {
        $container = $this->getTesteeInstance();

        self::assertFalse($container->has('service'));
        self::assertCount(0, self::getPropertyValue($container, 'definitions'));
    }

    protected function getTesteeInstance(
        ?IServiceSpawnerFactory $spawnerFactory = null,
        ?Traversable $definitions = null,
    ): IContainer {
        return
            new Container(
                spawnerFactory: $spawnerFactory ?? $this->getSpawnerFactoryMock(),
                definitions: $definitions,
            );
    }

    private function getSpawnerFactoryMock(): MockObject&IServiceSpawnerFactory
    {
        return $this->createMock(IServiceSpawnerFactory::class);
    }

    #[Test]
    public function canBeInstantiatedWithEmptyDefinitions(): void
    {
        $container = $this->getTesteeInstance(definitions: new ArrayObject([]));

        self::assertFalse($container->has('foo'));
        self::assertCount(0, self::getPropertyValue($container, 'definitions'));
    }

    #[Test]
    public function canBeInstantiatedWithDefinitions(): void
    {
        $container = $this->getTesteeInstance(
            definitions: new ArrayObject([
                'foo' => new ServiceDefinition('foo', stdClass::class),
                'bar' => new ServiceDefinition('bar', stdClass::class),
            ])
        );

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));
        self::assertCount(2, self::getPropertyValue($container, 'definitions'));
    }

    #[Test]
    public function canBeInstantiatedWithDefinitionsWithoutIds(): void
    {
        $container = $this->getTesteeInstance(
            definitions: new ArrayObject([
                new ServiceDefinition('foo', stdClass::class),
                new ServiceDefinition('bar', stdClass::class),
            ])
        );

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));
        self::assertCount(2, self::getPropertyValue($container, 'definitions'));
    }

    #[Test]
    public function throwsIfNoServiceFoundById(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'There is no service with id "foo" in the container.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(definitions: new ArrayObject([]));

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsIfClassIsNotFound(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);


        $spawner = $this->getServiceSpawnerMock();

        $spawnerFactory = $this->getSpawnerFactoryMock();
        $spawnerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($spawner)
        ;

        $spawner
            ->expects(self::once())
            ->method('spawn')
            ->with(self::isInstanceOf(IServiceDefinition::class))
            ->willThrowException(new SpawnFailed('Class does not exist: bar'))
        ;

        $definitions = new ArrayObject([
            'foo' => new ServiceDefinition('foo', 'bar'),
        ]);

        $container = $this->getTesteeInstance(
            spawnerFactory: $spawnerFactory,
            definitions: $definitions,
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    protected function getServiceSpawnerMock(): MockObject&IServiceSpawner
    {
        return $this->createMock(IServiceSpawner::class);
    }

    #[Test]
    public function throwsWhenFailsToInstantiateServiceByConstructor(): void
    {
        $exceptionClass = ContainerException::class;

        $this->expectException($exceptionClass);

        $spawner = $this->getServiceSpawnerMock();

        $spawnerFactory = $this->getSpawnerFactoryMock();
        $spawnerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($spawner)
        ;

        $spawner
            ->expects(self::once())
            ->method('spawn')
            ->with(self::isInstanceOf(IServiceDefinition::class))
            ->willThrowException(new ContainerException())
        ;

        $definitions =
            new ArrayObject([
                'foo' => new ServiceDefinition('foo', NonInstantiableClass::class),
            ]);

        $container = $this->getTesteeInstance(
            spawnerFactory: $spawnerFactory,
            definitions: $definitions,
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass));
    }

    #[Test]
    public function throwsWhenOneOfDefinitionsAlreadyRegistered(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Definition with id "foo" already registered.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $definitions = static function (): Generator {
            yield new ServiceDefinition('foo', 'bar');
            yield 'foo' => new ServiceDefinition('foo', 'bar');
        };

        $container = $this->getTesteeInstance(definitions: $definitions());

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
