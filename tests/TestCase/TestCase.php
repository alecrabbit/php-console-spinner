<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Tests\TestCase\Mixin\AppRelatedConstTrait;
use ArrayAccess;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Throwable;

use function AlecRabbit\Tests\TestCase\Sneaky\peek;
use function array_key_exists;
use function is_array;
use function is_string;

abstract class TestCase extends PHPUnitTestCase
{
    use AppRelatedConstTrait;

    final protected const REPEATS = 10;
    final protected const FLOAT_EQUALITY_DELTA = 0.0000001;
    private const FORMAT_THROWABLE = "%s('%s')";

    protected static function getPropertyValue(object|string $objectOrClass, string $propertyName): mixed
    {
        return peek($objectOrClass)->{$propertyName};
    }

    protected static function setPropertyValue(object|string $objectOrClass, string $propertyName, mixed $value): void
    {
        peek($objectOrClass)->{$propertyName} = $value;
    }

    protected static function callMethod(mixed $objectOrClass, string $methodName, ...$args): mixed
    {
        return peek($objectOrClass)->{$methodName}(...$args);
    }

    protected static function failTest(string|Throwable $messageOrException): never
    {
        $message =
            is_string($messageOrException)
                ? $messageOrException
                : self::exceptionNotThrownString($messageOrException);

        self::fail($message);
    }

    protected static function exceptionNotThrownString(
        string|Throwable $messageOrException,
        ?string $exceptionMessage = null
    ): string {
        if (
            is_string($messageOrException)
            && class_exists($messageOrException)
            && is_subclass_of($messageOrException, Throwable::class)
        ) {
            $messageOrException = new $messageOrException($exceptionMessage ?? '');
        }
        return 'Exception not thrown: ' . self::throwable($messageOrException);
    }

    protected static function throwable(Throwable $t, bool $unwrap = true): string
    {
        $class = $t::class;
        $message = $t->getMessage();
        $aux = $unwrap ? ' [' . $class . ']' : '';
        return sprintf(
                self::FORMAT_THROWABLE,
                self::classShortName($class),
                $message
            ) . $aux;
    }

    protected static function classShortName(string|object $fqcn): string
    {
        if (is_object($fqcn)) {
            $fqcn = $fqcn::class;
        }
        $parts = explode('\\', $fqcn);
        return end($parts);
    }

    protected static function getFaker(): FakerGenerator
    {
        return FakerFactory::create();
    }

    protected function expectsException(mixed $expected): ?Throwable
    {
        if (
            (is_array($expected) || $expected instanceof ArrayAccess)
            && array_key_exists(self::EXCEPTION, $expected)
        ) {
            $exceptionClass = $expected[self::EXCEPTION][self::CLASS_];
            $exceptionMessage = '';
            $this->expectException($exceptionClass);
            if (array_key_exists(self::MESSAGE, $expected[self::EXCEPTION])) {
                $exceptionMessage = $expected[self::EXCEPTION][self::MESSAGE];
                $this->expectExceptionMessage($exceptionMessage);
            }
            return new $exceptionClass($exceptionMessage);
        }
        return null;
    }

    protected function wrapExceptionTest(
        callable $test,
        string|Throwable $exception,
        ?string $message = null,
        array $args = []
    ): void {
        if ($exception instanceof Throwable) {
            $message = $exception->getMessage();
            $exception = $exception::class;
        }

        $this->expectException($exception);

        if ($message !== null) {
            $this->expectExceptionMessage($message);
        }

        $test(...$args);

        self::fail(
            sprintf(
                '%s',
                self::exceptionNotThrownString($exception, $message)
            )
        );
    }
}
