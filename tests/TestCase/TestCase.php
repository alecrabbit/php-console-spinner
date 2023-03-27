<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\TestCase;

use AlecRabbit\Tests\Spinner\Helper\PickLock;
use AlecRabbit\Tests\Spinner\Mixin\AppRelatedConstantsTrait;
use ArrayAccess;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Throwable;

use function array_key_exists;
use function is_array;

abstract class TestCase extends PHPUnitTestCase
{
    use AppRelatedConstantsTrait;

    final protected const REPEATS = 10;
    final protected const FLOAT_EQUALITY_DELTA = 0.0000001;

    protected static function getValue(string $property, mixed $from): mixed
    {
        return PickLock::getValue($from, $property);
    }

    protected static function setValue(object|string $objectOrClass, string $propertyName, mixed $value): void
    {
        PickLock::setValue($objectOrClass, $propertyName, $value);
    }

    protected static function callMethod(mixed $objectOrClass, string $methodName, ...$args): mixed
    {
        return PickLock::callMethod($objectOrClass, $methodName, ...$args);
    }

    protected static function exceptionNotThrown(
        string|Throwable $e,
        ?string $exceptionMessage = null,
        ?array $dataSet = null
    ): never {
        if (is_string($e)) {
            $e = new $e($exceptionMessage ?? '');
        }
        $message = sprintf(
            'Exception [%s]%s is not thrown.',
            $e::class,
            $e->getMessage() === '' ? '' : ' with message: "' . $e->getMessage() . '"'
        );

        if (null !== $dataSet) {
            dump($dataSet); // intentional dump
        }

        self::fail($message);
    }

    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
    }

    /**
     * @param mixed $expected
     * @return null|Throwable
     */
    protected function expectsException(mixed $expected): ?Throwable
    {
        if ((is_array($expected) || $expected instanceof ArrayAccess)
            && array_key_exists(self::EXCEPTION, $expected)) {
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
}
