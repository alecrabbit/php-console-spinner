<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class IntervalNormalizerTest extends TestCase
{
    public static function normalizeData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::INTERVAL => 100,
            ],
            [
                self::ARGUMENTS => [
                    self::DIVISOR => 50,
                    self::INTERVAL => 100,
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('normalizeData')]
    public function canNormalize(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $divisor = $incoming[self::ARGUMENTS][self::DIVISOR];
        $interval = $incoming[self::ARGUMENTS][self::INTERVAL];
        IntervalNormalizer::setDivisor($divisor);
        $normalized = IntervalNormalizer::normalize($interval);
        self::assertSame($expected[self::INTERVAL], $normalized);
    }

    //    /**
    //     * @test
    //     * @dataProvider createDataProvider
    //     */
    //    public function create(array $expected, array $incoming): void
    //    {
    //        $this->setExpectException($expected);
    //
    //        $frame = self::getInstance($incoming[self::ARGUMENTS] ?? []);
    //
    //        self::assertSame($expected[self::SEQUENCE], $frame->sequence());
    //        self::assertSame($expected[self::WIDTH], $frame->width());
    //    }
}

