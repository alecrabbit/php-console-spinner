<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\TestCase;

use AlecRabbit\Tests\Spinner\Helper\PickLock;
use AlecRabbit\Tests\Spinner\Mixin\AppRelatedConstantsTrait;
use ArrayAccess;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

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

    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
    }

    protected function setExpectException(mixed $expected): void
    {
        if ((is_array($expected) || $expected instanceof ArrayAccess)
            && array_key_exists(self::EXCEPTION, $expected)) {
            $this->expectException($expected[self::EXCEPTION][self::CLASS_]);
            if (array_key_exists(self::MESSAGE, $expected[self::EXCEPTION])) {
                $this->expectExceptionMessage($expected[self::EXCEPTION][self::MESSAGE]);
            }
        }
    }
}
