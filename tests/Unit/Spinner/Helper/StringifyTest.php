<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Helper;

use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Helper\Stringify;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class StringifyTest extends TestCase
{
    public static function stringifyValueDataProvider(): iterable
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
        #4
        yield [
            [
                self::RESULT => 'boolean(true)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => true,
                ],
            ],
        ];
        #5
        yield [
            [
                self::RESULT => 'boolean(false)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => false,
                ],
            ],
        ];
        #6
        yield [
            [
                self::RESULT => 'NULL',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => null,
                ],
            ],
        ];
        #7
        yield [
            [
                self::RESULT => 'array',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => [],
                ],
            ],
        ];
        #8
        yield [
            [
                self::RESULT => 'object(stdClass)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => new stdClass(),
                ],
            ],
        ];
        #9
        yield [
            [
                self::RESULT => 'object',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => new ArrayObject(),
                    self::UNWRAP => false,
                ],
            ],
        ];
        #10
        yield [
            [
                self::RESULT => 'object(ArrayObject)',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => new ArrayObject(),
                ],
            ],
        ];
        #11
        yield [
            [
                self::RESULT => 'resource',
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => STDOUT,
                ],
            ],
        ];
        #12
        yield [
            [
                self::RESULT => "DomainException('DomainException message') [AlecRabbit\Spinner\Exception\DomainException]",
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => new DomainException('DomainException message'),
                ],
            ],
        ];
    }
    public static function stringifyThrowableDataProvider(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::RESULT => "DomainException('DomainException message') [AlecRabbit\Spinner\Exception\DomainException]",
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => new DomainException('DomainException message'),
                ],
            ],
        ];
        #1
        yield [
            [
                self::RESULT => "DomainException('DomainException message')",
            ],
            [
                self::ARGUMENTS => [
                    self::VALUE => new DomainException('DomainException message'),
                    self::UNWRAP => false,
                ],
            ],
        ];

    }

    #[Test]
    #[DataProvider('stringifyValueDataProvider')]
    public function canStringifyValue(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = Stringify::value($args[self::VALUE], $args[self::UNWRAP] ?? true);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    #[Test]
    #[DataProvider('stringifyThrowableDataProvider')]
    public function canStringifyThrowable(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = Stringify::throwable($args[self::VALUE], $args[self::UNWRAP] ?? true);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

}
