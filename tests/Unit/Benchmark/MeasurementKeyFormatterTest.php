<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;


use AlecRabbit\Benchmark\Contract\IMeasurementKeyFormatter;
use AlecRabbit\Benchmark\MeasurementKeyFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class MeasurementKeyFormatterTest extends TestCase
{
    public static function canFormatDataProvider(): iterable
    {
        yield from [
            // result, [$key, $prefix]
            ['key', ['key', null]],
            ['key', ['aakey', 'aa']],
            ['keyaa', ['keyaa', 'aa']],
            [':method:', ['FF\TT\MM:method:', 'FF\TT\MM']],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(MeasurementKeyFormatter::class, $formatter);
    }

    private function getTesteeInstance(): IMeasurementKeyFormatter
    {
        return new MeasurementKeyFormatter();
    }

    #[Test]
    #[DataProvider('canFormatDataProvider')]
    public function canFormat(string $result, array $incoming): void
    {
        $formatter = $this->getTesteeInstance();

        [$key, $prefix] = $incoming;

        self::assertEquals($result, $formatter->format($key, $prefix));
    }
}
