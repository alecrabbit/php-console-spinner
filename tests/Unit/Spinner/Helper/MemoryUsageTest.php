<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Helper;

use AlecRabbit\Spinner\Helper\MemoryUsage;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class MemoryUsageTest extends TestCase
{
    public static function memoryUsageDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedMemoryUsageDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => 'Memory usage: ' . $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::VALUE => $item[1],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedMemoryUsageDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, memoryUsage // first element - #0..
            ['1000B', 1000],
            ['1.95KB', 2000],
            ['1.91MB', 2000000],
            ['4.22GB', 4532000000],
            ['9.31GB', 9999999999],
            ['1GB', 1073741824],
            ['1MB', 1048576],
            ['3MB', 3145728],
            ['1.5MB', 1572864],
        ];
    }

    #[Test]
    #[DataProvider('memoryUsageDataProvider')]
    public function canStringifyValue(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = MemoryUsage::report($args[self::VALUE]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }
}
