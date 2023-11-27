<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Functional\Helper;

use AlecRabbit\Lib\Helper\BytesFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class BytesFormatterTest extends TestCase
{
    public static function bytesFormatterDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedBytesFormatterDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::VALUE => $item[1],
                        self::PREFIX => $item[2] ?? null,
                    ],
                ],
            ];
        }
    }

    public static function simplifiedBytesFormatterDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, memoryUsage // first element - #0..
            ['8B', 8],
            ['234B', 234],
            ['1000B', 1000],
            ['1.95KB', 2000],
            ['1.91MB', 2000000],
            ['1GB', 1073741824],
            ['1.19GB', 1273741824],
            ['1023.96MB', 1073700000],
            ['1MB', 1048576],
            ['3MB', 3145728],
            ['6.81MB', 7145728],
            ['68.17MB', 71485728],
            ['1.5MB', 1572864],
            ['2GB', 2147483647], // max for 32-bit
        ];
        if (PHP_INT_SIZE === 8) {
            yield ['8EB', 9223372036854775807];
            yield ['40.27PB', 45345345632000000];
            yield ['4.22GB', 4532000000];
            yield ['9.31GB', 9999999999];
        }
    }

    #[Test]
    #[DataProvider('bytesFormatterDataProvider')]
    public function canFormatBytes(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $formatter = new BytesFormatter();
        $result = $formatter->format($args[self::VALUE]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }
}
