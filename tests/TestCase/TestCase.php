<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Helper\Stringify;
use AlecRabbit\Tests\Helper\PickLock;
use AlecRabbit\Tests\Mixin\AppRelatedConstTrait;
use ArrayAccess;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Throwable;

use function array_key_exists;
use function is_array;
use function is_string;

abstract class TestCase extends PHPUnitTestCase
{
    use AppRelatedConstTrait;

    final protected const REPEATS = 10;
    final protected const FLOAT_EQUALITY_DELTA = 0.0000001;

    protected static function getPropertyValue(string $property, mixed $from): mixed
    {
        return PickLock::getValue($from, $property);
    }

    protected static function setPropertyValue(object|string $objectOrClass, string $propertyName, mixed $value): void
    {
        PickLock::setValue($objectOrClass, $propertyName, $value);
    }

    protected static function callMethod(mixed $objectOrClass, string $methodName, ...$args): mixed
    {
        return PickLock::callMethod($objectOrClass, $methodName, ...$args);
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
        return 'Exception not thrown: ' . Stringify::throwable($messageOrException);
    }

    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
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
