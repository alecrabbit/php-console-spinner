<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class CharFrameTest extends TestCase
{
    public static function createDataProvider(): iterable
    {
        yield from self::createNormalData();
    }

    public static function createNormalData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::SEQUENCE => $sequence = '1',
                self::WIDTH => $width = 1,
            ],
            [
                self::ARGUMENTS => [
                    $sequence,
                    $width,
                ],
            ],
        ];
        yield [
            [
                self::SEQUENCE => $sequence = '   ',
                self::WIDTH => $width = 3,
            ],
            [
                self::ARGUMENTS => [
                    $sequence,
                    $width,
                ],
            ],
        ];
        yield [
            [
                self::SEQUENCE => $sequence = '----',
                self::WIDTH => $width = 4,
            ],
            [
                self::ARGUMENTS => [
                    $sequence,
                    $width,
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('createDataProvider')]
    public function create(array $expected, array $incoming): void
    {
        $this->expectsException($expected);

        $frame = self::getTesteeInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertSame($expected[self::SEQUENCE], $frame->getSequence());
        self::assertSame($expected[self::WIDTH], $frame->getWidth());
    }

    public static function getTesteeInstance(array $args = []): ISequenceFrame
    {
        return new CharFrame(...$args);
    }
}
