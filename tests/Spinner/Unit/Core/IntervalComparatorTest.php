<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalComparator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TypeError;

final class IntervalComparatorTest extends TestCase
{
    public static function canSmallestDataProvider(): iterable
    {
        yield from [
            // [result], [first, other:[]]
            // #0
            [
                [new Interval(10)],
                [new Interval(10), []],
            ],
            // #1
            [
                [new Interval(14)],
                [
                    new Interval(16),
                    [
                        new Interval(102),
                        new Interval(14),
                    ]
                ],
            ],
            // #2
            [
                [new Interval(10)],
                [
                    new Interval(176),
                    [
                        new Interval(10),
                        new Interval(414),
                    ]
                ],
            ],
            // #3
            [
                [new Interval(15)],
                [
                    new Interval(15),
                    [
                        new Interval(20),
                        new Interval(414),
                    ]
                ],
            ],
            // #4
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => TypeError::class,
                    ],
                ],
                [
                    1,
                    [],
                ],
            ],
            // #5
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => TypeError::class,
                    ],
                ],
                [
                    new Interval(),
                    [
                        '2',
                    ],
                ],
            ],
            // #6
            [
                [new Interval(10)],
                [new Interval(10), [null]],
            ],
            // #7
            [
                [new Interval(10)],
                [new Interval(100), [null, new Interval(10)]],
            ],
        ];
    }

    public static function canLargestDataProvider(): iterable
    {
        yield from [
            // [result], [first, other:[]]
            // #0
            [
                [new Interval(10)],
                [new Interval(10), []],
            ],
            // #1
            [
                [new Interval(106)],
                [
                    new Interval(36),
                    [
                        new Interval(106),
                        new Interval(24),
                    ]
                ],
            ],
            // #2
            [
                [new Interval(414)],
                [
                    new Interval(176),
                    [
                        new Interval(10),
                        new Interval(414),
                    ]
                ],
            ],
            // #3
            [
                [new Interval(222)],
                [
                    new Interval(222),
                    [
                        new Interval(20),
                        new Interval(122),
                    ]
                ],
            ],
            // #4
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => TypeError::class,
                    ],
                ],
                [
                    1,
                    [],
                ],
            ],
            // #5
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => TypeError::class,
                    ],
                ],
                [
                    new Interval(),
                    [
                        '2',
                    ],
                ],
            ],
            // #6
            [
                [new Interval(10)],
                [new Interval(10), [null]],
            ],
            // #7
            [
                [new Interval(100)],
                [new Interval(10), [null, new Interval(100)]],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $comparator = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalComparator::class, $comparator);
    }

    private function getTesteeInstance(): IIntervalComparator
    {
        return new IntervalComparator();
    }

    #[Test]
    #[DataProvider('canSmallestDataProvider')]
    public function canSmallest(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $result = $expected[0] ?? null;

        [$first, $other] = $incoming;

        $comparator = $this->getTesteeInstance();

        self::assertEquals($result, $comparator->smallest($first, ...$other));

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    #[Test]
    #[DataProvider('canLargestDataProvider')]
    public function canLargest(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $result = $expected[0] ?? null;

        [$first, $other] = $incoming;

        $comparator = $this->getTesteeInstance();

        self::assertEquals($result, $comparator->largest($first, ...$other));

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }
}
