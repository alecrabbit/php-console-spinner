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

        $this->assertFalse($container->has('foo'));
        $this->assertCount(0, self::getValue('definitions', $container));
    }

    #[Test]
    public function canBeCreatedWithDefinitions(): void
    {
        $container = new Container([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $this->assertTrue($container->has('foo'));
        $this->assertTrue($container->has('bar'));
        $this->assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canAddDefinitionsAfterCreate(): void
    {
        $container = new Container([]);

        $container->add('foo', 'bar');
        $container->add('bar', 'baz');

        $this->assertTrue($container->has('foo'));
        $this->assertTrue($container->has('bar'));
        $this->assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canGetDefinition(): void
    {
        $container = new Container([
            \stdClass::class => \stdClass::class,
            'foo' => fn () => new \stdClass(),
            'bar' => new \stdClass(),
        ]);

        $this->assertInstanceOf(\stdClass::class, $container->get(\stdClass::class));
        $this->assertInstanceOf(\stdClass::class, $container->get('foo'));
        $this->assertInstanceOf(\stdClass::class, $container->get('bar'));
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