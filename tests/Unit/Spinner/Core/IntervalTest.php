<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

use function array_key_exists;

class IntervalTest extends TestCase
{
    public function createDataProvider(): iterable
    {
        yield from $this->createNormalData();
        yield from $this->createExceptionData();
    }

    public function createNormalData(): iterable
    {
        // [$expected, $ms]
        yield [
            [
                self::INTERVAL => (float)(Defaults::getMaxIntervalMilliseconds() / 1000),
            ],
            null
        ];

        yield [
            [
                self::INTERVAL => 0.212,
            ],
            212
        ];

        yield from $this->createExceptionData();
    }

    public function createExceptionData(): iterable
    {
        // [$expected, $ms]
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

        $interval = new Interval($ms);

        if (array_key_exists(self::INTERVAL, $expected)) {
            self::assertEquals($expected[self::INTERVAL], $interval->toSeconds());
            self::assertSame($expected[self::INTERVAL], $interval->toSeconds());
        }
    }

    /**
     * @test
     */
    public function canClone(): void
    {
        $interval = new Interval(null);
        $clone = clone $interval;
        self::assertEquals($interval->toSeconds(), $clone->toSeconds());
        self::assertEquals($clone, $interval);
    }
}
