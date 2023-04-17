<?php

declare(strict_types=1);

// 27.03.23

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\SpawnFailedException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Container\Override\NonInstantiableClass;
use ArrayObject;
use Closure;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;
use Traversable;
use TypeError;

final class ContainerTest extends TestCase
{
    #[Test]
    public function canBeCreatedWithNullDefinitions(): void
    {
        $container = $this->getTesteeInstance();

        self::assertFalse($container->has('service'));
        self::assertCount(0, self::getPropertyValue('definitions', $container));
    }

    #[Test]
    public function canBeCreatedWithEmptyDefinitions(): void
    {
        $container = $this->getTesteeInstance(new ArrayObject([]));

        self::assertFalse($container->has('foo'));
        self::assertCount(0, self::getPropertyValue('definitions', $container));
    }

    #[Test]
    public function canBeCreatedWithDefinitions(): void
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
    public function canAddDefinitionsAfterCreate(): void
    {
        $container = $this->getTesteeInstance(new ArrayObject([]));

        $container->add('foo', 'bar');
        $container->add('bar', 'baz');

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
                'foo' => static fn () => new stdClass(),
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
    public function canRemoveDefinitionAndServiceRegisteredEarlier(): void
    {
        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => 'bar',
                'bar' => 'baz',
            ])
        );

        $container->remove('foo');
        $container->remove('bar');

        self::assertFalse($container->has('foo'));
        self::assertFalse($container->has('bar'));
        self::assertCount(0, self::getPropertyValue('definitions', $container));
        self::assertCount(0, self::getPropertyValue('services', $container));
    }

    #[Test]
    public function canReplaceDefinitionAndServiceRegisteredEarlier(): void
    {
        $serviceOne = new stdClass();
        $serviceTwo = new stdClass();
        $serviceThree = new stdClass();

        $replacedServiceOne = new stdClass();
        $replacedServiceTwo = new stdClass();
        $replacedServiceThree = new stdClass();

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => $serviceOne,
                'bar' => $serviceTwo,
                'baz' => $serviceThree,
            ]),
            function () use (
                $serviceOne,
                $serviceTwo,
                $replacedServiceTwo,
                $replacedServiceThree,
                $replacedServiceOne
            ): IServiceSpawner {
                $spawner = $this->getSpawnerInstanceMock();
                $spawner
                    ->method('spawn')
                    ->willReturn(
                        $serviceOne,            // #1
                        $serviceTwo,            // #2
                        $replacedServiceOne,    // #3
                        $replacedServiceTwo,    // #4
                        $replacedServiceThree,  // #5
                        $replacedServiceTwo,    // #6
                        $replacedServiceOne,    // #7
                        $replacedServiceThree   // #8
                    )
                ;
                return $spawner;
            }
        );
        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));

        self::assertSame($serviceOne, $container->get('foo')); // #1
        self::assertSame($serviceTwo, $container->get('bar')); // #2
        self::assertCount(2, self::getPropertyValue('services', $container));

        $container->replace('foo', $replacedServiceOne);    // #3
        $container->replace('bar', $replacedServiceTwo);    // #4
        $container->replace('baz', $replacedServiceThree);  // #5

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));

        self::assertCount(3, self::getPropertyValue('definitions', $container));
        // Services should also be replaced because we already retrieved two of them
        self::assertCount(2, self::getPropertyValue('services', $container));

        self::assertSame($replacedServiceTwo, $container->get('bar'));   // #6
        self::assertSame($replacedServiceOne, $container->get('foo'));   // #7
        self::assertSame($replacedServiceThree, $container->get('baz')); // #8

        self::assertCount(3, self::getPropertyValue('services', $container));
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

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => 'bar',
            ]),
            //ContainerException('Could not instantiate service for "foo". Class "bar" is not found.')
            function (): IServiceSpawner {
                $spawner = $this->getSpawnerInstanceMock();
                $spawner
                    ->expects(self::once())
                    ->method('spawn')
                    ->with(self::identicalTo('bar'))
                    ->willThrowException(new SpawnFailedException('Class does not exist: bar'))
                ;
                return $spawner;
            }
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsWhenBeCreatedWithInvalidDefinitions(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Definition should be callable, object or string, integer given.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => 'bar',
                'baz' => 1,
            ])
        );

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsWhenFailsToInstantiateServiceWithCallable(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service with callable for "foo".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $closure = static fn () => throw new InvalidArgumentException('Intentional exception.');
        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => $closure,
            ]),
            function () use ($closure, $exceptionMessage): IServiceSpawner {
                $spawner = $this->getSpawnerInstanceMock();
                $spawner
                    ->expects(self::once())
                    ->method('spawn')
                    ->with(self::identicalTo($closure))
                    ->willThrowException(new ContainerException($exceptionMessage))
                ;
                return $spawner;
            }
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsWhenFailsToInstantiateServiceByConstructor(): void
    {
        $exceptionClass = ContainerException::class;

        $this->expectException($exceptionClass);

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => NonInstantiableClass::class,
            ]),
            function (): IServiceSpawner {
                $instanceSpawner = $this->getSpawnerInstanceMock();
                $instanceSpawner
                    ->expects(self::once())
                    ->method('spawn')
                    ->with(self::identicalTo(NonInstantiableClass::class))
                    ->willThrowException(new ContainerException())
                ;
                return $instanceSpawner;
            }
        );

        $container->get('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass));
    }

    #[Test]
    public function throwsWhenAddedIdIsAlreadyRegistered(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Definition with id "foo" already registered in the container.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => 'bar',
            ])
        );

        $container->add('foo', 'baz');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
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

    #[Test]
    public function throwsWhenRemovingUnregisteredDefinition(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Definition with id "foo" is not registered in the container.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(new ArrayObject([]));

        $container->remove('foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsWhenReplacingUnregisteredDefinition(): void
    {
        $exceptionClass = ContainerException::class;
        $exceptionMessage = 'Definition with id "bar" is not registered in the container.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(new ArrayObject([]));

        $container->replace('bar', 'foo');

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsWhenSpawnerCbIsInvalid(): void
    {
        $exceptionClass = TypeError::class;

        $this->expectException($exceptionClass);

        $container = new Container(static fn () => 1, new ArrayObject([]));

        self::failTest(self::exceptionNotThrownString($exceptionClass));
    }

    protected function getTesteeInstance(?Traversable $definitions = null, ?Closure $spawnerCb = null): IContainer
    {
        $spawnerCb = $spawnerCb ?? function (): IServiceSpawner {
            return $this->getSpawnerInstanceMock();
        };

        return new Container(
            spawnerCreatorCb: $spawnerCb,
            definitions: $definitions,
        );
    }

    protected function getSpawnerInstanceMock(): MockObject&IServiceSpawner
    {
        return $this->createMock(IServiceSpawner::class);
    }
}
