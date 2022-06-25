<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Helper;

use Error;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

use function get_class;
use function is_object;
use function is_string;
use function method_exists;
use function property_exists;

/**
 * Class Picklock
 *
 * @link https://gitlab.com/m0rtis/picklock
 * @license Apache License 2.0
 * @author Anton Fomichev aka m0rtis - mail@m0rtis.ru
 *
 * @package AlecRabbit\Helpers\Objects
 * @author AlecRabbit
 *
 * @internal
 */
final class PickLock
{
    public const EXCEPTION_TEMPLATE = 'Class [%s] does not have %s "%s"';
    public const INVALID_ARGUMENT_EXCEPTION_STRING = 'Param 1 should be object or a class-string.';
    public const METHOD = 'method';
    public const PROPERTY = 'property';

    /**
     * Calls a private or protected method of an object.
     *
     * @param mixed $objectOrClass
     * @param string $methodName
     * @param mixed ...$args
     *
     * @return mixed
     */
    public static function callMethod(mixed $objectOrClass, string $methodName, ...$args): mixed
    {
        $objectOrClass = self::getObject($objectOrClass);
        $closure =
            /**
             * @param string $methodName
             * @param array $args
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
        return
            $closure->call($objectOrClass, $methodName, ...$args);
    }

    /**
     * @psalm-suppress TypeCoercion
     * @psalm-suppress InvalidStringClass
     *
     * @param object|string $objectOrClass
     *
     * @return object
     */
    protected static function getObject(object|string $objectOrClass): object
    {
        self::assertParam($objectOrClass);

        if (is_string($objectOrClass)) {
            try {
                $objectOrClass = new $objectOrClass();
            } catch (Error $e) {
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
     * @param mixed $objectOrClass
     */
    protected static function assertParam(mixed $objectOrClass): void
    {
        if (!is_string($objectOrClass) && !is_object($objectOrClass)) {
            throw new InvalidArgumentException(self::INVALID_ARGUMENT_EXCEPTION_STRING);
        }
    }

    /**
     * Creates an error message.
     *
     * @param object $object
     * @param string $part
     * @param bool $forMethod
     *
     * @return string
     */
    public static function errorMessage(object $object, string $part, bool $forMethod): string
    {
        return
            sprintf(
                self::EXCEPTION_TEMPLATE,
                get_class($object),
                $forMethod ? self::METHOD : self::PROPERTY,
                $part,
            );
    }

    /**
     * Gets a value of a private or protected property of an object.
     *
     * @param object|string $objectOrClass
     * @param string $propertyName
     *
     * @return mixed
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
        return
            $closure->bindTo($objectOrClass, $objectOrClass)();
    }

    /**
     * @param object|string $objectOrClass
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     */
    public static function setValue(object|string $objectOrClass, string $propertyName, mixed $value): mixed
    {
        $objectOrClass = self::getObject($objectOrClass);
        $closure =
            /**
             * @throws ReflectionException
             */
            function (mixed $value) use ($propertyName) {
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
        return
            $closure->bindTo($objectOrClass, $objectOrClass)($value);
    }
}
