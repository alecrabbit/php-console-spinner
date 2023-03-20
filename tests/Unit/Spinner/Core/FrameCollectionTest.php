<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Exception\DomainException;
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
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Empty collection.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::FRAMES => new ArrayObject([]),
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Empty collection.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::FRAMES =>
                        (static function (){
                            yield from [];
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
    }

    #[Test]
    #[DataProvider('collectionData')]
    public function canBeCreated(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $collection = new FrameCollection($args[self::FRAMES]);

        self::assertSame($expected[self::LAST_INDEX] ?? null, $collection->lastIndex());
        self::assertSame($expected[self::COUNT] ?? null, $collection->count());
        self::assertSame($expected[self::FRAMES] ?? null, $collection->getArrayCopy());

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

    }
}


