<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Settings\Contract\IRevolverSettings;
use AlecRabbit\Spinner\Core\Settings\RevolverSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RevolverSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?ITolerance $tolerance = null,
    ): IRevolverSettings {
        return
            new RevolverSettings(
                tolerance: $tolerance ?? $this->getToleranceMock(),
            );
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IRevolverSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetTolerance(): void
    {
        $tolerance = $this->getToleranceMock();

        $settings = $this->getTesteeInstance(
            tolerance: $tolerance,
        );

        self::assertSame($tolerance, $settings->getTolerance());
    }
}
