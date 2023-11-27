<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Helper;

use Error;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

use function is_string;
use function method_exists;
use function property_exists;

/**
 * Class PickLock
 *
 * @author AlecRabbit
 *
 * @internal
 */
final class PickLock
{
    private const EXCEPTION_TEMPLATE = 'Class [%s] does not have %s "%s"';
    private const METHOD = 'method';
    private const PROPERTY = 'property';

    /**
     * Calls a private or protected method of an object.
     */
    public static function callMethod(mixed $objectOrClass, string $methodName, ...$args): mixed
    {
        $objectOrClass = self::getObject($objectOrClass);
        $closure =
            /**
             * @param string $methodName
             * @param array $args
             *
             * @return mixed
             */
            function (string $methodName, ...$args) {
                if (method_exists($this, $methodName)) {
                    return $this->$methodName(...$args);
                }
                throw new RuntimeException(
                    PickLock::errorMessage($this, $methodName, true)
                );
            };
        return $closure->call($objectOrClass, $methodName, ...$args);
    }

    /**
     * @psalm-suppress TypeCoercion
     * @psalm-suppress InvalidStringClass
     */
    private static function getObject(object|string $objectOrClass): object
    {
        if (is_string($objectOrClass)) {
            try {
                $objectOrClass = new $objectOrClass();
            } catch (Error $_) {
                try {
                    $class = new ReflectionClass($objectOrClass);
                    $objectOrClass = $class->newInstanceWithoutConstructor();
                    // @codeCoverageIgnoreStart
                } catch (ReflectionException $exception) {
                    throw new RuntimeException(
                        '[' . get_debug_type($exception) . '] ' . $exception->getMessage(),
                        (int)$exception->getCode(),
                        $exception
                    );
                }
                // @codeCoverageIgnoreEnd
            }
        }
        return $objectOrClass;
    }

    /**
     * Creates an error message.
     */
    public static function errorMessage(object $object, string $part, bool $forMethod): string
    {
        return sprintf(
            self::EXCEPTION_TEMPLATE,
            $object::class,
            $forMethod ? self::METHOD : self::PROPERTY,
            $part,
        );
    }

    /**
     * Gets a value of a private or protected property of an object.
     */
    public static function getValue(object|string $objectOrClass, string $propertyName): mixed
    {
        $objectOrClass = self::getObject($objectOrClass);
        $closure =
            /**
             * @throws ReflectionException
             */
            function () use ($propertyName): mixed {
                if (property_exists($this, $propertyName)) {
                    $class = new ReflectionClass(get_debug_type($this));
                    $property = $class->getProperty($propertyName);
                    $property->setAccessible(true);
                    return $property->getValue($this);
                }
                throw new RuntimeException(
                    PickLock::errorMessage($this, $propertyName, false)
                );
            };
        return $closure->bindTo($objectOrClass, $objectOrClass)();
    }

    public static function setValue(object|string $objectOrClass, string $propertyName, mixed $value): mixed
    {
        $objectOrClass = self::getObject($objectOrClass);
        $closure =
            /**
             * @throws ReflectionException
             */
            function (mixed $value) use ($propertyName): void {
                if (property_exists($this, $propertyName)) {
                    $class = new ReflectionClass(get_debug_type($this));
                    $property = $class->getProperty($propertyName);
                    $property->setAccessible(true);
                    $property->setValue($this, $value);
                    return;
                }
                throw new RuntimeException(
                    PickLock::errorMessage($this, $propertyName, false)
                );
            };
        return $closure->bindTo($objectOrClass, $objectOrClass)($value);
    }
}
