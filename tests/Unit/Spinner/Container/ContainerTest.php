<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Definition;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\SpawnFailed;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Container\Override\NonInstantiableClass;
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
        self::assertCount(0, self::getPropertyValue('definitions', $container));
    }

    protected function getTesteeInstance(
        ?IServiceSpawnerBuilder $spawnerBuilder = null,
        ?ICircularDependencyDetector $circularDependencyDetector = null,
        ?Traversable $definitions = null,
    ): IContainer {
        return
            new Container(
                spawnerBuilder: $spawnerBuilder ?? $this->getSpawnerBuilderMock(),
                circularDependencyDetector: $circularDependencyDetector ?? $this->getCircularDependencyDetectorMock(),
                definitions: $definitions,
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

    #[Test]
    public function canBeInstantiatedWithEmptyDefinitions(): void
    {
        $container = $this->getTesteeInstance(definitions: new ArrayObject([]));

        self::assertFalse($container->has('foo'));
        self::assertCount(0, self::getPropertyValue('definitions', $container));
    }

    #[Test]
    public function canBeInstantiatedWithDefinitions(): void
    {
        $container = $this->getTesteeInstance(
            definitions: new ArrayObject([
                'foo' => new Definition('foo', stdClass::class),
                'bar' => new Definition('bar', stdClass::class),
            ])
        );

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));
        self::assertCount(2, self::getPropertyValue('definitions', $container));
    }

    #[Test]
    public function canGetServiceAndItIsSameServiceEveryTime(): void
    {
        $container = $this->getTesteeInstance(
            definitions: new ArrayObject([
                'foo' => new Definition('foo', static fn() => new stdClass()),
                'bar' => new Definition('bar', new stdClass()),
                stdClass::class => new Definition(stdClass::class, stdClass::class),
            ])
        );

        $serviceOne = $container->get(stdClass::class);
        self::assertInstanceOf(stdClass::class, $serviceOne);
        self::assertSame($serviceOne, $container->get(stdClass::class));

        $serviceTwo = $container->get('foo');
        self::assertInstanceOf(stdClass::class, $serviceTwo);
        self::assertSame($serviceTwo, $container->get('foo'));

        $serviceThree = $container->get('bar');
        self::assertInstanceOf(stdClass::class, $serviceThree);
        self::assertSame($serviceThree, $container->get('bar'));
    }

    #[Test]
    public function canGetServiceAndItIsDifferentServiceEveryTime(): void
    {
        $foo = 'foo';
        $bar = 'bar';

        $container = $this->getTesteeInstance(
            definitions: new ArrayObject([
                stdClass::class => new Definition(stdClass::class, stdClass::class, IDefinition::TRANSIENT),
                $foo => new Definition($foo, static fn() => new stdClass(), IDefinition::TRANSIENT),
                $bar => new Definition($bar, new stdClass(), IDefinition::TRANSIENT),
            ])
        );

        $serviceOne = $container->get(stdClass::class);
        self::assertInstanceOf(stdClass::class, $serviceOne);
        self::assertNotSame($serviceOne, $container->get(stdClass::class));

        $serviceTwo = $container->get($foo);
        self::assertInstanceOf(stdClass::class, $serviceTwo);
        self::assertNotSame($serviceTwo, $container->get($foo));

        $serviceThree = $container->get($bar);
        self::assertInstanceOf(stdClass::class, $serviceThree);
        self::assertNotSame($serviceThree, $container->get($bar));
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

        $spawnerBuilder = $this->getSpawnerBuilderMock();

        $spawnerBuilder
            ->expects(self::once())
            ->method('withContainer')
            ->willReturnSelf()
        ;
        $spawnerBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($spawner)
        ;

        $spawner
            ->expects(self::once())
            ->method('spawn')
            ->with(self::isInstanceOf(IDefinition::class))
            ->willThrowException(new SpawnFailed('Class does not exist: bar'))
        ;

        $definitions = new ArrayObject([
            'foo' => new Definition('foo', 'bar'),
        ]);

        $container = $this->getTesteeInstance(
            spawnerBuilder: $spawnerBuilder,
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
    public function throwsWhenFailsToInstantiateServiceWithCallable(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service with callable for "foo".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $spawner = $this->getServiceSpawnerMock();

        $spawnerBuilder = $this->getSpawnerBuilderMock();

        $spawnerBuilder
            ->expects(self::once())
            ->method('withContainer')
            ->willReturnSelf()
        ;
        $spawnerBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($spawner)
        ;

        $closure = static fn() => throw new InvalidArgumentException('Intentional exception.');

        $spawner
            ->expects(self::once())
            ->method('spawn')
            ->with(self::isInstanceOf(IDefinition::class))
            ->willThrowException(new ContainerException($exceptionMessage))
        ;

        $definitions = new ArrayObject([
            'foo' => new Definition('foo', $closure),
        ]);

        $container = $this->getTesteeInstance(
            spawnerBuilder: $spawnerBuilder,
            definitions: $definitions,
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsWhenFailsToInstantiateServiceByConstructor(): void
    {
        $exceptionClass = ContainerException::class;

        $this->expectException($exceptionClass);

        $spawner = $this->getServiceSpawnerMock();

        $spawnerBuilder = $this->getSpawnerBuilderMock();

        $spawnerBuilder
            ->expects(self::once())
            ->method('withContainer')
            ->willReturnSelf()
        ;
        $spawnerBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($spawner)
        ;

        $spawner
            ->expects(self::once())
            ->method('spawn')
            ->with(self::isInstanceOf(IDefinition::class))
            ->willThrowException(new ContainerException())
        ;

        $definitions =
            new ArrayObject([
                'foo' => new Definition('foo', NonInstantiableClass::class),
            ]);

        $container = $this->getTesteeInstance(
            spawnerBuilder: $spawnerBuilder,
            definitions: $definitions,
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass));
    }

    #[Test]
    public function throwsWhenOneOfDefinitionsAlreadyRegistered(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Definition with id "foo" already registered in the container.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $definitions = static function (): Generator {
            yield 'foo' => new Definition('foo', 'bar');
            yield 'foo' => new Definition('foo', 'bar');
        };

        $container = $this->getTesteeInstance(definitions: $definitions());

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
