<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\IntegerNormalizer;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
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
                    self::INTERVAL => new Interval($item[0]), // result
                ],
                [
                    self::ARGUMENTS => [
                        self::INTERVAL => new Interval($item[1]), // interval
                        self::DIVISOR => $item[2], // divisor
                        self::MIN => $item[3], // divisor
                    ],
                ],
            ];
        }
    }

    public static function simplifiedDataFeeder(): iterable
    {
        yield from [
            // result, interval, divisor, min,
            [100, 100, 20, 20],
            [120, 115, 20, 20],
            [100, 124, 50, 50],
            [150, 135, 50, 50],
            [50, 10, 50, 50],
            [10, 10, 50, 10],
            [50, 25, 50, 50],
            [50, 25, 50, 10],

        ];
    }

    #[Test]
    #[DataProvider('normalizeData')]
    public function canNormalize(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $normalizer = $this->getTesteeInstance($args);

        self::assertEquals(
            $expected[self::INTERVAL],
            $normalizer->normalize($args[self::INTERVAL])
        );

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    public function getTesteeInstance(array $args = []): IIntervalNormalizer
    {
        $min = $args[self::MIN] ?? 10;
        $divisor = $args[self::DIVISOR] ?? 20;

        return new IntervalNormalizer(
            new IntegerNormalizer($divisor, $min)
        );
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $intervalNormalizer = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalNormalizer::class, $intervalNormalizer);
    }
}
