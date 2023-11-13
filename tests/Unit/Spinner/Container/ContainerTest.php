<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\SpawnFailedException;
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
        ?Traversable $definitions = null,
        ?IServiceSpawnerBuilder $spawnerBuilder = null,
    ): IContainer {
        return new Container(
            spawnerBuilder: $spawnerBuilder ?? $this->getSpawnerBuilderMock(),
            definitions: $definitions,
        );
    }

    private function getSpawnerBuilderMock(): MockObject&IServiceSpawnerBuilder
    {
        return $this->createMock(IServiceSpawnerBuilder::class);
    }

    #[Test]
    public function canBeInstantiatedWithEmptyDefinitions(): void
    {
        $container = $this->getTesteeInstance(new ArrayObject([]));

        self::assertFalse($container->has('foo'));
        self::assertCount(0, self::getPropertyValue('definitions', $container));
    }

    #[Test]
    public function canBeInstantiatedWithDefinitions(): void
    {
        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => 'bar',
                'bar' => 'baz',
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
            new ArrayObject([
                stdClass::class => stdClass::class,
                'foo' => static fn() => new stdClass(),
                'bar' => new stdClass(),
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
    public function throwsIfNoServiceFoundById(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'There is no service with id "foo" in the container.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(new ArrayObject([]));

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsIfClassIsNotFound(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service with id "foo".';

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
            ->with(self::identicalTo('bar'))
            ->willThrowException(new SpawnFailedException('Class does not exist: bar'))
        ;

        $definitions = new ArrayObject([
            'foo' => 'bar',
        ]);

        $container = $this->getTesteeInstance(
            definitions: $definitions,
            spawnerBuilder: $spawnerBuilder,
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    protected function getServiceSpawnerMock(): MockObject&IServiceSpawner
    {
        return $this->createMock(IServiceSpawner::class);
    }

    #[Test]
    public function throwsWhenCreatedWithInvalidDefinitions(): void
    {
        $this->wrapExceptionTest(
            function (): void {
                $container = $this->getTesteeInstance(
                    new ArrayObject([
                        'foo' => 'bar',
                        'baz' => 1,
                    ])
                );
                self::assertInstanceOf(Container::class, $container);
            },
            new ContainerException(
                'Definition should be callable, object or string, "integer" given.'
            )
        );
    }
    #[Test]
    public function throwsWhenCreatedWithInvalidDefinitionsTwo(): void
    {
        $this->wrapExceptionTest(
            function (): void {
                $definition = new class() implements IDefinition {
                    public function getId(): string
                    {
                        throw new \RuntimeException('INTENTIONALLY Not implemented.');
                    }

                    public function getDefinition(): object|callable|string
                    {
                        throw new \RuntimeException('INTENTIONALLY Not implemented.');
                    }

                    public function getOptions(): int
                    {
                        throw new \RuntimeException('INTENTIONALLY Not implemented.');
                    }
                };

                $container = $this->getTesteeInstance(
                    new ArrayObject([
                        'foo' => $definition,
                    ])
                );
                self::assertInstanceOf(Container::class, $container);
            },
            new ContainerException(
                'Unsupported definition, "AlecRabbit\Spinner\Container\Contract\IDefinition" given.',
            )
        );
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
            ->with(self::identicalTo($closure))
            ->willThrowException(new ContainerException($exceptionMessage))
        ;

        $definitions = new ArrayObject([
            'foo' => $closure,
        ]);

        $container = $this->getTesteeInstance(
            definitions: $definitions,
            spawnerBuilder: $spawnerBuilder,
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
            ->with(self::identicalTo(NonInstantiableClass::class))
            ->willThrowException(new ContainerException())
        ;

        $definitions =
            new ArrayObject([
                'foo' => NonInstantiableClass::class,
            ]);

        $container = $this->getTesteeInstance(
            definitions: $definitions,
            spawnerBuilder: $spawnerBuilder,
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
            yield 'foo' => 'bar';
            yield 'foo' => 'bar';
        };
        $container = $this->getTesteeInstance($definitions());

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
