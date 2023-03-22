<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A\Override\FrameClass;

final class AFrameTest extends TestCase
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

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $incoming): void
    {
        $this->expectsException($expected);

        $frame = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertSame($expected[self::SEQUENCE], $frame->sequence());
        self::assertSame($expected[self::WIDTH], $frame->width());
    }

    public static function getInstance(array $args = []): IFrame
    {
        return new FrameClass(...$args);
    }

    /**
     * @test
     */
    public function createEmpty(): void
    {
        $frame = FrameFactory::createEmpty();

        self::assertSame('', $frame->sequence());
        self::assertSame(0, $frame->width());
    }

    /**
     * @test
     */
    public function createSpace(): void
    {
        $frame = FrameFactory::createSpace();

        self::assertSame(' ', $frame->sequence());
        self::assertSame(1, $frame->width());
    }

}
