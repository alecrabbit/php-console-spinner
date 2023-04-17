<?php

declare(strict_types=1);

// 15.02.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\IntegerNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class IntegerNormalizerTest extends TestCase
{
    public static function normalizeData(): iterable
    {
        // [$expected, $incoming]
        foreach (self::simplifiedDataFeeder() as $item) {
            yield [
                [
                    self::INTERVAL => $item[1], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::INTERVAL => $item[2], // interval
                        self::DIVISOR => $item[0], // divisor
                    ],
                ],
            ];
        }
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Divisor should be greater than 0.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::INTERVAL => 100,
                    self::DIVISOR => 0,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Divisor should be less than 1000000.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::INTERVAL => 100,
                    self::DIVISOR => 1200000,
                ],
            ],
        ];
    }

    public static function simplifiedDataFeeder(): iterable
    {
        yield from [
            // divisor, result, interval,
            [50, 100, 100,],
            [10, 100, 100,],
            [100, 100, 100,],
            [100, 400, 400,],
            [50, 500, 490,],
            [50, 450, 450,],
            [50, 500, 475,],
            [50, 450, 474,],
            [1000, 0, 474,],
            [1000, 1000, 500,],
        ];
    }

    #[Test]
    #[DataProvider('normalizeData')]
    public function canNormalize(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $normalizer = new IntegerNormalizer($args[self::DIVISOR]);

        self::assertSame(
            $expected[self::INTERVAL],
            $normalizer->normalize($args[self::INTERVAL])
        );

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    #[Test]
    public function throwOnInvalidSetMin(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Min should be greater than 0.';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $normalizer = new IntegerNormalizer(min: -1);

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
