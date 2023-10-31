<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Stopwatch\Result;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ResultTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $result = $this->getTesteeInstance();

        self::assertInstanceOf(Result::class, $result);
    }

    private function getTesteeInstance(
        null|int|float $average = null,
        null|int|float $min = null,
        null|int|float $max = null,
        null|int $count = null,
    ): IResult {
        return new Result(
            average: $average ?? $this->getFaker()->randomFloat(),
            min: $min ?? $this->getFaker()->randomFloat(),
            max: $max ?? $this->getFaker()->randomFloat(),
            count: $count ?? $this->getFaker()->randomDigit(),
        );
    }

    #[Test]
    public function canGetAverage(): void
    {
        $average = 2.23;

        $result = $this->getTesteeInstance(
            average: $average,
        );

        self::assertSame($average, $result->getAverage());
    }

    #[Test]
    public function canGetMin(): void
    {
        $min = 0.224;

        $result = $this->getTesteeInstance(
            min: $min,
        );

        self::assertSame($min, $result->getMin());
    }

    #[Test]
    public function canGetMax(): void
    {
        $max = 140.68;

        $result = $this->getTesteeInstance(
            max: $max,
        );

        self::assertSame($max, $result->getMax());
    }

    #[Test]
    public function canGetCount(): void
    {
        $count = 933;

        $result = $this->getTesteeInstance(
            count: $count,
        );

        self::assertSame($count, $result->getCount());
    }
}
