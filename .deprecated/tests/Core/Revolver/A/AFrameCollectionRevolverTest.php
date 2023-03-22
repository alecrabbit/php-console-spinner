<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Revolver\A\AFrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use TypeError;

final class AFrameCollectionRevolverTest extends TestCase
{
    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $incoming): void
    {
        $this->expectsException($expected);

        $instance = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertEquals($expected[self::RESULT][0], $instance->update());
    }

    public static function getInstance(array $args = []): AFrameCollectionRevolver
    {
        return new class(...$args) extends AFrameCollectionRevolver {
        };
    }

    /**
     * @test
     * @dataProvider arrayAccessDataProvider
     */
    public function arrayAccess(array $expected, array $incoming): void
    {
        $this->expectsException($expected);

        $instance = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        $indexes = $expected[self::INDEXES];
        foreach ($indexes as $index) {
            self::assertSame($expected[self::RESULT][$index], $instance[$index]);
        }
    }

    /**
     * @test
     */
    public function shouldThrowOnOffsetUnset(): void
    {
        $this->expectsException([
            self::EXCEPTION => [
                self::CLASS_ => LogicException::class,
                self::MESSAGE => 'Collection is immutable.',
            ],
        ]);

        $instance = self::getInstance([
            [
                FrameFactory::create('fr0', 3),
                FrameFactory::create('fr1', 3),
                FrameFactory::create('fr2', 3),
            ],
            new Interval(),
        ]);

        unset($instance[0]);

        self::fail('Exception should be thrown');
    }

    /**
     * @test
     */
    public function shouldThrowOnOffsetSet(): void
    {
        $this->expectsException([
            self::EXCEPTION => [
                self::CLASS_ => LogicException::class,
                self::MESSAGE => 'Collection is immutable.',
            ],
        ]);

        $instance = self::getInstance([
            [
                FrameFactory::create('fr0', 3),
                FrameFactory::create('fr1', 3),
                FrameFactory::create('fr2', 3),
            ],
            new Interval(),
        ]);

        $instance[4] = FrameFactory::create('fr4', 3);

        self::assertTrue(isset($instance[4]));

        self::fail('Exception should be thrown');
    }

    /**
     * @test
     */
    public function arrayAccessOffsetExists(): void
    {
        $this->expectsException([]);

        $instance = self::getInstance([
            [
                FrameFactory::create('fr0', 3),
                FrameFactory::create('fr1', 3),
                FrameFactory::create('fr2', 3),
            ],
            new Interval(),
        ]);

        self::assertTrue(isset($instance[2]));
        self::assertTrue(isset($instance[0]));
        self::assertTrue(isset($instance[1]));
        self::assertFalse(isset($instance[4]));
    }

    /**
     * @test
     */
    public function cycle(): void
    {
        $this->expectsException([]);

        $instance = self::getInstance([
            [
                $frame0 = FrameFactory::create('fr0', 3),
                $frame1 = FrameFactory::create('fr1', 3),
                $frame2 = FrameFactory::create('fr2', 3),
            ],
            new Interval(),
        ]);

        self::assertSame($frame1, $instance->update());
        self::assertSame($frame2, $instance->update());
        self::assertSame($frame0, $instance->update());
        self::assertSame($frame1, $instance->update());
        self::assertSame($frame2, $instance->update());
    }

    public static function createDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Collection is empty.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    [],
                    new Interval(),
                ],
            ],
        ];
        // #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => TypeError::class,
                    self::MESSAGE => 'addFrame(): Argument #1 ($frame) must be of type AlecRabbit\Spinner\Contract\IFrame, null given',
                ],
            ],
            [
                self::ARGUMENTS => [
                    [null],
                    new Interval(),
                ],
            ],
        ];
        // #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => TypeError::class,
                    self::MESSAGE => 'addFrame(): Argument #1 ($frame) must be of type AlecRabbit\Spinner\Contract\IFrame, string given',
                ],
            ],
            [
                self::ARGUMENTS => [
                    ['string'],
                    new Interval(),
                ],
            ],
        ];
        // #3
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => TypeError::class,
                    self::MESSAGE => 'addFrame(): Argument #1 ($frame) must be of type AlecRabbit\Spinner\Contract\IFrame, int given',
                ],
            ],
            [
                self::ARGUMENTS => [
                    [1],
                    new Interval(),
                ],
            ],
        ];
        // #4
        yield [
            [
                self::RESULT => [
                    $frame0 = FrameFactory::create('frame', 5),
                ],
            ],
            [
                self::ARGUMENTS => [
                    [$frame0],
                    new Interval(),
                ],
            ],
        ];
    }

    public static function arrayAccessDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Collection is empty.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    [],
                    new Interval(),
                ],
            ],
        ];
        // #1
        yield [
            [
                self::RESULT => [
                    $frame0 = FrameFactory::create('fr0', 3),
                ],
                self::INDEXES => [0],
            ],
            [
                self::ARGUMENTS => [
                    [$frame0],
                    new Interval(),
                ],
            ],
        ];
        // #2
        yield [
            [
                self::RESULT => [
                    $frame0 = FrameFactory::create('fr0', 3),
                    $frame1 = FrameFactory::create('fr1', 3),
                    $frame2 = FrameFactory::create('fr2', 3),
                ],
                self::INDEXES => [2, 0, 1],
            ],
            [
                self::ARGUMENTS => [
                    [$frame0, $frame1, $frame2],
                    new Interval(),
                ],
            ],
        ];
        // #3
        yield [
            [
                self::RESULT => [
                    $frame0 = FrameFactory::create('fr0', 3),
                    $frame1 = FrameFactory::create('fr0', 3),
                ],
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Invalid offset type. Offset must be an integer, "string" given.',
                ],
                self::INDEXES => ['1'],
            ],
            [
                self::ARGUMENTS => [
                    [$frame0, $frame1],
                    new Interval(),
                ],
            ],
        ];
        // #4
        yield [
            [
                self::RESULT => [
                    $frame0 = FrameFactory::create('fr0', 3),
                    $frame1 = FrameFactory::create('fr1', 3),
                    $frame2 = FrameFactory::create('fr2', 3),
                ],
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Undefined offset "2".',
                ],
                self::INDEXES => [2],
            ],
            [
                self::ARGUMENTS => [
                    [$frame0, $frame1],
                    new Interval(),
                ],
            ],
        ];
    }
}
