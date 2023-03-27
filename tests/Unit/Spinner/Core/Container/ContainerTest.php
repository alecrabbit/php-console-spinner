<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Container;

use AlecRabbit\Spinner\Core\Container\Container;
use AlecRabbit\Spinner\Core\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Container\Override\NonInstantiableClass;
use PHPUnit\Framework\Attributes\Test;

final class ContainerTest extends TestCase
{
    #[Test]
    public function canBeCreatedEmpty(): void
    {
        $container = new Container([]);

        self::assertFalse($container->has('foo'));
        self::assertCount(0, self::getValue('definitions', $container));
    }

    #[Test]
    public function canBeCreatedWithDefinitions(): void
    {
        $container = new Container([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));
        self::assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canAddDefinitionsAfterCreate(): void
    {
        $container = new Container([]);

        $container->add('foo', 'bar');
        $container->add('bar', 'baz');

        self::assertTrue($container->has('foo'));
        self::assertTrue($container->has('bar'));
        self::assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canGetServiceAndItIsSameServiceEveryTime(): void
    {
        $container = new Container([
            \stdClass::class => \stdClass::class,
            'foo' => fn () => new \stdClass(),
            'bar' => new \stdClass(),
        ]);

        $serviceOne = $container->get(\stdClass::class);
        self::assertInstanceOf(\stdClass::class, $serviceOne);
        self::assertSame($serviceOne, $container->get(\stdClass::class));
        
        $serviceTwo = $container->get('foo');
        self::assertInstanceOf(\stdClass::class, $serviceTwo);
        self::assertSame($serviceTwo, $container->get('foo'));

        $serviceThree = $container->get('bar');
        self::assertInstanceOf(\stdClass::class, $serviceThree);
        self::assertSame($serviceThree, $container->get('bar'));
    }

    #[Test]
    public function throwsWhenInvalidDefinitionsAreAdded(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'Definition should be callable, object or string, integer given.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([]);

        $container->add('baz', 1);

        self::exceptionNotThrown($exception, $exceptionMessage);
    }

    #[Test]
    public function throwsIfNoServiceFoundById(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'There is not service with id "foo" in the container.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([]);

        $container->get('foo');

        self::exceptionNotThrown($exception, $exceptionMessage);
    }

    #[Test]
    public function throwsIfClassIsNotFound(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service for "foo". Class "bar" is not found.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([
            'foo' => 'bar',
        ]);

        $container->get('foo');

        self::exceptionNotThrown($exception, $exceptionMessage);
    }

    #[Test]
    public function throwsWhenBeCreatedWithInvalidDefinitions(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'Definition should be callable, object or string, integer given.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([
            'foo' => 'bar',
            'baz' => 1,
        ]);

        self::exceptionNotThrown($exception, $exceptionMessage);
    }

    #[Test]
    public function throwsWhenFailsToInstantiateServiceWithCallable(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service with callable for "foo".';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([
            'foo' => fn () => throw new \InvalidArgumentException('Intentional exception.'),
        ]);

        $container->get('foo');

        self::exceptionNotThrown($exception, $exceptionMessage);
    }

    #[Test]
    public function throwsWhenFailsToInstantiateServiceByConstructor(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'Could not instantiate service by __construct() for "foo".';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([
            'foo' => NonInstantiableClass::class,
        ]);

        $container->get('foo');

        self::exceptionNotThrown($exception, $exceptionMessage);
    }
}