<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class IntervalNormalizerTest extends TestCase
{
    public static function normalizeData(): iterable
    {
        // [$expected, $incoming]
        foreach (self::simplifiedDataFeeder() as $item) {
            yield [
                [
                    self::INTERVAL => $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::INTERVAL => $item[1],
                        self::DIVISOR => $item[2],
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
                    self::DIVISOR => 0,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Divisor should be less than 1000.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::DIVISOR => 1200,
                ],
            ],
        ];
    }

    public static function simplifiedDataFeeder(): iterable
    {
        yield from [
            // result, interval, divisor
            [100, 100, 50],
            [100, 100, 10],
            [100, 100, 100],
            [400, 400, 100],
            [500, 490, 50],
            [450, 450, 50],
            [500, 475, 50],
            [450, 474, 50],
        ];
    }

    #[Test]
    #[DataProvider('normalizeData')]
    public function canNormalize(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $args = $incoming[self::ARGUMENTS];

        IntervalNormalizer::setDivisor($args[self::DIVISOR]);

        self::assertSame(
            $expected[self::INTERVAL],
            IntervalNormalizer::normalize($args[self::INTERVAL])
        );
    }
}


