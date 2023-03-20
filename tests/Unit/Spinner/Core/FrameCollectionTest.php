<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class FrameCollectionTest extends TestCase
{
    public static function collectionData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::COUNT => 0,
                self::FRAMES => $frames = [],
                self::LAST_INDEX => null,
            ],
            [
                self::ARGUMENTS => [
                    self::FRAMES => new ArrayObject($frames),
                ],
            ],
        ];
        yield [
            [
                self::COUNT => 0,
                self::FRAMES => $frames,
                self::LAST_INDEX => null,
            ],
            [
                self::ARGUMENTS => [
                    self::FRAMES =>
                        (static function () use ($frames) {
                            yield from $frames;
                        })(),

                ],
            ],
        ];
        yield [
            [
                self::COUNT => 3,
                self::FRAMES =>
                    $frames = [
                        FrameFactory::create('a', 1),
                        FrameFactory::create('b', 1),
                        FrameFactory::create('c', 1)
                    ],
                self::LAST_INDEX => 2,
            ],
            [
                self::ARGUMENTS => [
                    self::FRAMES =>
                        (static function () use ($frames) {
                            yield from $frames;
                        })(),

                ],
            ],
        ];
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Divisor should be greater than 0.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::INTERVAL => 100,
//                    self::DIVISOR => 0,
//                ],
//            ],
//        ];
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Divisor should be less than 1000000.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::INTERVAL => 100,
//                    self::DIVISOR => 1200000,
//                ],
//            ],
//        ];
    }

    #[Test]
    #[DataProvider('collectionData')]
    public function canBeCreated(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $collection = new FrameCollection($args[self::FRAMES]);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertSame($expected[self::COUNT], $collection->count());
        self::assertSame($expected[self::FRAMES], $collection->getArrayCopy());
        self::assertSame($expected[self::LAST_INDEX], $collection->lastIndex());
    }
}


