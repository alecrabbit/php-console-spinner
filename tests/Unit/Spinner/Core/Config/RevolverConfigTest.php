<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RevolverConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverConfig::class, $config);
    }

    protected function getTesteeInstance(?ITolerance $tolerance = null): IRevolverConfig
    {
        if ($tolerance === null) {
            return new RevolverConfig();
        }

        return
            new RevolverConfig(
                tolerance: $tolerance,
            );
    }

    #[Test]
    public function canGetTolerance(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(Tolerance::class, $config->getTolerance());
    }

    #[Test]
    public function canGetToleranceFromConstructor(): void
    {
        $tolerance = $this->getToleranceMock();

        $config = $this->getTesteeInstance(
            tolerance: $tolerance,
        );

        self::assertSame($tolerance, $config->getTolerance());
    }

    protected function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

}
