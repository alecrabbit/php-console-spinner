<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A\Override\FrameClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class AFloatValueTest extends TestCase
{
    public static function createDataProvider(): iterable
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

    }

    #[Test]
    #[DataProvider('createDataProvider')]
    public function create(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $frame = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertSame($expected[self::SEQUENCE], $frame->sequence());
        self::assertSame($expected[self::WIDTH], $frame->width());
    }

    public static function getInstance(array $args = []): IFrame
    {
        return new FrameClass(...$args);
    }
}
