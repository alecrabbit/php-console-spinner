<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;


use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\DatetimeFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

final class DatetimeFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(DatetimeFormatter::class, $formatter);
    }

    private function getTesteeInstance(
        ?string $format = null,
    ): IDatetimeFormatter {
        if ($format !== null) {
            return new DatetimeFormatter($format);
        }
        return new DatetimeFormatter();
    }

    #[Test]
    public function canFormat(): void
    {
        $formatter = $this->getTesteeInstance();
        $datetime = new DateTimeImmutable('2021-01-01 00:00:00.000000');
        $format = 'Y-m-d H:i:s.u';
        $expected = '2021-01-01 00:00:00.000000';
        self::assertEquals($expected, $formatter->format($datetime, $format));
    }
}
