<?php

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\IntegerNormalizer;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class IntervalNormalizerTest extends TestCaseWithPrebuiltMocks
{
    public static function normalizeData(): iterable
    {
        // [$expected, $incoming]
        foreach (self::simplifiedDataFeeder() as $item) {
            yield [
                [
                    self::INTERVAL => new Interval($item[1]), // result
                ],
                [
                    self::ARGUMENTS => [
                        self::INTERVAL => new Interval($item[2]), // interval
                    ],
                ],
            ];
        }
    }

    public static function simplifiedDataFeeder(): iterable
    {
        yield from [
            // mode, result, interval,
            [NormalizerMode::SMOOTH, 100, 100,],
            [NormalizerMode::SMOOTH, 100, 110,],
            [NormalizerMode::BALANCED, 100, 124,],
            [NormalizerMode::BALANCED, 150, 135,],
            [NormalizerMode::BALANCED, 10, 10,],
            [NormalizerMode::BALANCED, 50, 25,],

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
        $mode = $args[self::MODE] ?? NormalizerMode::BALANCED;
        $min = $args[self::MIN] ?? IInterval::MIN_INTERVAL_MILLISECONDS;

        return
            new IntervalNormalizer(
                new IntegerNormalizer(
                    $mode->getDivisor(),
                    $min
                )
            );
    }

    #[Test]
    public function canBeCreated(): void
    {
        $intervalNormalizer = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalNormalizer::class, $intervalNormalizer);
    }
}
