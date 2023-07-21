<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetSettings {
        return
            new WidgetSettings(
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
            );
    }

    #[Test]
    public function canGetLeadingSpacer(): void
    {
        $leadingSpacer = $this->getFrameMock();

        $settings = $this->getTesteeInstance(
            leadingSpacer: $leadingSpacer,
        );

        self::assertSame($leadingSpacer, $settings->getLeadingSpacer());
    }

    #[Test]
    public function canSetLeadingSpacer(): void
    {
        $settings = $this->getTesteeInstance();

        $leadingSpacer = $this->getFrameMock();

        self::assertNotSame($leadingSpacer, $settings->getLeadingSpacer());

        $settings->setLeadingSpacer($leadingSpacer);

        self::assertSame($leadingSpacer, $settings->getLeadingSpacer());
    }

    #[Test]
    public function canGetTrailingSpacer(): void
    {
        $trailingSpacer = $this->getFrameMock();

        $settings = $this->getTesteeInstance(
            trailingSpacer: $trailingSpacer,
        );

        self::assertSame($trailingSpacer, $settings->getTrailingSpacer());
    }

    #[Test]
    public function canSetTrailingSpacer(): void
    {
        $settings = $this->getTesteeInstance();

        $trailingSpacer = $this->getFrameMock();

        self::assertNotSame($trailingSpacer, $settings->getTrailingSpacer());

        $settings->setTrailingSpacer($trailingSpacer);

        self::assertSame($trailingSpacer, $settings->getTrailingSpacer());
    }
}
