<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    protected const CONTAINS = 'contains';
    protected const COUNT = 'count';
    protected const INTERVAL = 'interval';
    protected const SEQUENCE = 'sequence';
    protected const RESULT = 'result';
    protected const EXCEPTION = 'exception';
    protected const _CLASS = 'class';
    protected const MESSAGE = 'message';
    protected const ARGUMENTS = 'arguments';
    protected const PATTERN = 'pattern';
    protected const EXTRACTED = 'extracted';
    protected const RENDERED = 'rendered';

    protected function checkForExceptionExpectance(mixed $expected): void
    {
        if (is_array($expected) && array_key_exists(self::EXCEPTION, $expected)) {
            $this->expectException($expected[self::EXCEPTION][self::_CLASS]);
            if (array_key_exists(self::MESSAGE, $expected[self::EXCEPTION])) {
                $this->expectExceptionMessage($expected[self::EXCEPTION][self::MESSAGE]);
            }
        }
    }
}
