<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
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

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }
}
