<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Kernel;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Rotor\WInterval;
use AlecRabbit\Tests\Spinner\TestCase;

class IntervalTest extends TestCase
{
    public function createDataProvider(): iterable
    {
        // [$expected, $styles, $interval]
        yield [
            [
                self::INTERVAL => (float)Defaults::MILLISECONDS_INTERVAL / 1000,
            ],
            null
        ];

        yield [
            [
                self::INTERVAL => 0.212,
            ],
            212
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Interval should be greater than %s.',
                            Defaults::MILLISECONDS_MIN_INTERVAL
                        ),
                ],
            ],
            Defaults::MILLISECONDS_MIN_INTERVAL - 10
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Interval should be less than %s.',
                            Defaults::MILLISECONDS_MAX_INTERVAL
                        ),
                ],
            ],
            Defaults::MILLISECONDS_MAX_INTERVAL + 1000
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, mixed $ms): void
    {
        $this->setExpectException($expected);

        $interval = new WInterval($ms);

        self::assertEquals($expected[self::INTERVAL], $interval->toSeconds());
        self::assertSame($expected[self::INTERVAL], $interval->toSeconds());
    }

//    /**
//     * @test
//     * @dataProvider smallestDataProvider
//     */
//    public function smallest(?IInterval $expected, array $arguments): void  {
//
//    }
//
//    public function smallestDataProvider(): iterable
//    {
//        yield [
//            null,
//            [
//                null,
//                null
//            ],
//        ];
//    }

    /**
     * @test
     */
    public function canClone(): void {
        $interval = new WInterval(Defaults::MILLISECONDS_INTERVAL);
        $clone = clone $interval;
        self::assertEquals($interval->toSeconds(), $clone->toSeconds());
        self::assertEquals($clone, $interval);
    }
}
