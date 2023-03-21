<?php

declare(strict_types=1);
// 21.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Style\CustomStyle;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class StyleFrameRendererTest extends TestCase
{
    public static function collectionData(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should not be empty string.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle(['']),
                ],
            ],
        ];
        #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be positive integer, -1 given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([-1]),
                ],
            ],
        ];
        #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI24 color mode rendering from int is not allowed.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([0], colorMode: ColorMode::ANSI24),
                ],
            ],
        ];
        #3
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI8 color mode value should be in range 0..255, 256 given.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([256], colorMode: ColorMode::ANSI8),
                ],
            ],
        ];
        #4
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI4 color mode value should be in range 0..16, 256 given.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([256], colorMode: ColorMode::ANSI4),
                ],
            ],
        ];
        #5
        yield [
            [
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([196], colorMode: ColorMode::ANSI8),
                ],
            ],
        ];

//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => DomainException::class,
//                    self::MESSAGE => 'Empty collection.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::FRAMES =>
//                        (static function (){
//                            yield from [];
//                        })(),
//
//                ],
//            ],
//        ];
//        yield [
//            [
//                self::COUNT => 3,
//                self::FRAMES =>
//                    $frames = [
//                        FrameFactory::create('a', 1),
//                        FrameFactory::create('b', 1),
//                        FrameFactory::create('c', 1)
//                    ],
//                self::LAST_INDEX => 2,
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::FRAMES =>
//                        (static function () use ($frames) {
//                            yield from $frames;
//                        })(),
//
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

        $collection = (new StyleFrameRenderer($args[self::PATTERN]))->render();

//        self::assertSame($expected[self::LAST_INDEX] ?? null, $collection->lastIndex());

        self::assertSame($expected[self::COUNT] ?? 1, $collection->count());
        self::assertEquals($expected[self::FRAMES] ?? null, $collection->getArrayCopy());

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }
    }
}
