<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Helper\Benchmark;

use AlecRabbit\Spinner\Core\Loop\Factory\LoopFactory;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IMeasurement;
use AlecRabbit\Spinner\Helper\Benchmark\Measurement;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class MeasurementTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(Measurement::class, $measurement);
    }

    private function getTesteeInstance(): IMeasurement
    {

    }
}
