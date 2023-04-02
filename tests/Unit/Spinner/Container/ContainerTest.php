<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override\NonInstantiableClass;
use ArrayObject;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;
use TypeError;

final class ContainerTest extends TestCase
{
    #[Test]
    public function canBeCreatedWithNullDefinitions(): void
    {
        $container = $this->getTesteeInstance();

        self::assertFalse($container->has('service'));
        self::assertCount(0, self::getValue('definitions', $container));
    }

    protected function getTesteeInstance(?\Traversable $definitions = null, ?\Closure $spawnerCb = null): IContainer
    {
        $spawnerCb = $spawnerCb ?? function (): IServiceSpawner {
            return $this->getSpawnerInstanceMock();
        };

        return new Container(
            spawnerCb: $spawnerCb,
            definitions: $definitions,
        );
    }

    protected function getSpawnerInstanceMock(): MockObject&IServiceSpawner
    {
        return $this->createMock(IServiceSpawner::class);
    }

    #[Test]
    public function canBeCreatedWithEmptyDefinitions(): void
    {
        $container = $this->getTesteeInstance(new ArrayObject([]));

        self::assertFalse($container->has('foo'));
        self::assertCount(0, self::getValue('definitions', $container));
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
        self::assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canAddDefinitionsAfterCreate(): void
    {
        $container = $this->getTesteeInstance(new ArrayObject([]));

        $container->add('foo', 'bar');
        $container->add('bar', 'baz');

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));
        self::assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canGetServiceAndItIsSameServiceEveryTime(): void
    {
        $container = $this->getTesteeInstance(
            new ArrayObject([
                stdClass::class => stdClass::class,
                'foo' => fn() => new stdClass(),
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
        self::assertCount(0, self::getValue('definitions', $container));
        self::assertCount(0, self::getValue('services', $container));
    }

    #[Test]
    public function canReplaceDefinitionAndServiceRegisteredEarlier(): void
    {
        $serviceOne = new stdClass();
        $serviceTwo = new stdClass();
        $serviceThree = new stdClass();

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => $serviceOne,
                'bar' => $serviceTwo,
                'baz' => $serviceThree,
            ])
        );
        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));

        self::assertSame($serviceOne, $container->get('foo'));
        self::assertSame($serviceTwo, $container->get('bar'));
        self::assertCount(2, self::getValue('services', $container));

        $replacedServiceOne = new stdClass();
        $replacedServiceTwo = new stdClass();
        $replacedServiceThree = new stdClass();

        $container->replace('foo', $replacedServiceOne);
        $container->replace('bar', $replacedServiceTwo);
        $container->replace('baz', $replacedServiceThree);

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));

        self::assertCount(3, self::getValue('definitions', $container));
        // Services should also be replaced because we already retrieved two them
        self::assertCount(2, self::getValue('services', $container));

        self::assertSame($replacedServiceTwo, $container->get('bar')); // intentionally changed order
        self::assertSame($replacedServiceThree, $container->get('baz'));
        self::assertSame($replacedServiceOne, $container->get('foo'));

        self::assertCount(3, self::getValue('services', $container));
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
        $exceptionMessage = 'Could not instantiate service for "foo". Class "bar" is not found.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => 'bar',
            ])
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

        $container = $this->getTesteeInstance(
            new ArrayObject([
                'foo' => fn() => throw new InvalidArgumentException('Intentional exception.'),
            ])
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
                    ->willThrowException(new ContainerException());
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

        $container = new Container(fn() => 1, new ArrayObject([]));

        self::failTest(self::exceptionNotThrownString($exceptionClass));
    }
}
