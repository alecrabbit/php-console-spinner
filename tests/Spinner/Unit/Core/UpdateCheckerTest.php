<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Core\UpdateChecker;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class UpdateCheckerTest extends TestCase
{
    public static function canIsDueDataProvider(): iterable
    {
        // [ $input:[$interval, $tolerance], $expected:[[$dt, $result],...] ]
        yield from [
            [
                [100, 0],
                [
                    [null, true],
                    [0, false],
                    [100, true],
                    [90, false],
                    [20, false],
                    [0, true],
                ]
            ],
            [
                [100, 15],
                [
                    [null, true],
                    [0, false],
                    [100, true],
                    [90, true],
                    [20, false],
                    [0, false],
                ]
            ],

        ];
    }

    #[Test]
    #[DataProvider('canIsDueDataProvider')]
    public function canIsDue(array $input, array $expected): void
    {
        [$interval, $tolerance] = $input;
        $checker = new UpdateChecker($interval, $tolerance);

        foreach ($expected as $item) {
            [$dt, $result] = $item;
            self::assertSame($result, $checker->isDue($dt));
        }
    }

}
