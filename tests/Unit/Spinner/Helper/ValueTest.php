<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Helper\Value;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Throwable;

final class ValueTest extends TestCase
{
    public static function stringifyDataProvider(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::RESULT => 'string(abc)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => 'abc',
                    self::UNWRAP => true,
                ],
            ],
        ];
        #1
        yield [
            [
                self::RESULT => 'string',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => 'abc',
                    self::UNWRAP => false,
                ],
            ],
        ];
        #2
        yield [
            [
                self::RESULT => 'integer(123)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => 123,
                ],
            ],
        ];
        #3
        yield [
            [
                self::RESULT => 'double(123.456)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => 123.456,
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('stringifyDataProvider')]
    public function canAssertSubClass(array $expected, array $incoming): void
    {

        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = Value::stringify($args[self::VALUE], $args[self::UNWRAP] ?? true);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }
        self::assertSame($expected[self::RESULT], $result);
    }

}
