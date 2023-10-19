<?php

declare(strict_types=1);

namespace Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\MeasurementFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MeasurementFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(MeasurementFormatter::class, $measurement);
    }

    private function getTesteeInstance(

    ): IMeasurementFormatter {
        return
            new MeasurementFormatter(

            );
    }

}
