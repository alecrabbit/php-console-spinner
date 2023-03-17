<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\A\AInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AIntervalTest extends TestCase
{
    public static function createDataProvider(): iterable
    {
        yield from self::createNormalData();
        yield from self::createExceptionData();
    }

    public static function createNormalData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::INTERVAL => (float)(IInterval::MAX_INTERVAL_MILLISECONDS / 1000),
            ],
            [
                self::ARGUMENTS => [],
            ],
        ];

        yield [
            [
                self::INTERVAL => 0.212,
            ],
            [
                self::ARGUMENTS => [
                    212,
                ],
            ],
        ];

        yield [
            [
                self::INTERVAL => 0.135,
            ],
            [
                self::ARGUMENTS => [
                    135,
                ],
            ],
        ];

        yield [
            [
                self::INTERVAL => 10.0,
            ],
            [
                self::ARGUMENTS => [
                    10000,
                ],
            ],
        ];

        yield [
            [
                self::INTERVAL => (float)(IInterval::MIN_INTERVAL_MILLISECONDS / 1000),
            ],
            [
                self::ARGUMENTS => [
                    IInterval::MIN_INTERVAL_MILLISECONDS,
                ],
            ],
        ];

        yield [
            [
                self::INTERVAL => (float)(IInterval::MAX_INTERVAL_MILLISECONDS / 1000),
            ],
            [
                self::ARGUMENTS => [
                    IInterval::MAX_INTERVAL_MILLISECONDS,
                ],
            ],
        ];
    }

    public static function createExceptionData(): iterable
    {
        // [$expected, $ms]
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Interval should be greater than or equal to %s.',
                            IInterval::MIN_INTERVAL_MILLISECONDS
                        ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    IInterval::MIN_INTERVAL_MILLISECONDS - 10,
                ],
            ],
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Interval should be less than or equal to %s.',
                            IInterval::MAX_INTERVAL_MILLISECONDS
                        ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    IInterval::MAX_INTERVAL_MILLISECONDS + 1000,
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $interval = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        if (array_key_exists(self::INTERVAL, $expected)) {
            self::assertEquals($expected[self::INTERVAL], $interval->toSeconds());
            self::assertSame($expected[self::INTERVAL], $interval->toSeconds());
        }
    }

    public static function getInstance(array $args = []): IInterval
    {
        return new class(...$args) extends AInterval {
        };
    }

    /**
     * @test
     */
    public function canClone(): void
    {
        $interval = self::getInstance();
        $clone = clone $interval;
        self::assertEquals($interval->toSeconds(), $clone->toSeconds());
        self::assertEquals($interval->toMicroseconds(), $clone->toMicroseconds());
        self::assertEquals($interval->toMilliseconds(), $clone->toMilliseconds());
        self::assertEquals($clone, $interval);
        self::assertNotSame($clone, $interval);
    }

    /**
     * @test
     * @dataProvider smallestDataProvider
     */
    public function canCalculateSmallest(array $expected, array $incoming): void
    {
        $interval = self::getInstance($incoming[self::FIRST] ?? []);
        $other = self::getInstance($incoming[self::SECOND] ?? []);
        self::assertEquals($expected[self::INTERVAL], $interval->smallest($other)->toMilliseconds());
        self::assertSame((float)$expected[self::INTERVAL], $interval->smallest($other)->toMilliseconds());
    }

    public static function smallestDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::INTERVAL => 100,
            ],
            [
                self::FIRST => [
                    100,
                ],
                self::SECOND => [
                    200
                ],
            ],
        ];

        yield [
            [
                self::INTERVAL => 50,
            ],
            [
                self::FIRST => [
                    100,
                ],
                self::SECOND => [
                    50
                ],
            ],
        ];

        yield [
            [
                self::INTERVAL => 35,
            ],
            [
                self::FIRST => [
                    1000,
                ],
                self::SECOND => [
                    35
                ],
            ],
        ];
    }
}
