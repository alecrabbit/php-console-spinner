<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    final protected const ARGUMENTS = 'arguments';
    final protected const CLASS_ = 'class';
    final protected const CONTAINS = 'contains';
    final protected const COUNT = 'count';
    final protected const EXCEPTION = 'exception';
    final protected const EXTRACTED = 'extracted';
    final protected const INTERVAL = 'interval';
    final protected const MESSAGE = 'message';
    final protected const PATTERN = 'pattern';
    final protected const PREFERRED_INTERVAL = 'preferredInterval';
    final protected const RENDERED = 'rendered';
    final protected const PROVIDED = 'provided';
    final protected const RESULT = 'result';
    final protected const SEQUENCE = 'sequence';
    final protected const SEQUENCE_START = 'sequenceStart';
    final protected const SEQUENCE_END = 'sequenceEnd';

    protected function setExpectException(mixed $expected): void
    {
        if ((\is_array($expected) || $expected instanceof \ArrayAccess)
            && \array_key_exists(self::EXCEPTION, $expected)) {
            $this->expectException($expected[self::EXCEPTION][self::CLASS_]);
            if (\array_key_exists(self::MESSAGE, $expected[self::EXCEPTION])) {
                $this->expectExceptionMessage($expected[self::EXCEPTION][self::MESSAGE]);
            }
        }
    }
}
