<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttach;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\LegacySpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\LegacySpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerSettingsBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySpinnerSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(
        ?ILoopProbe $loopProbe = null,
    ): ILegacySpinnerSettingsBuilder {
        return
            new LegacySpinnerSettingsBuilder(
                loopProbe: $loopProbe,
            );
    }

    #[Test]
    public function attachOptionIsDisabledIfLoopProbeIsNull(): void
    {
        $settings = $this->getTesteeInstance()->build();

        self::assertInstanceOf(LegacySpinnerSettings::class, $settings);

        self::assertSame(OptionAttach::DISABLED, $settings->getAttachOption());
        self::assertSame(OptionInitialization::ENABLED, $settings->getInitializationOption());
    }

    #[Test]
    public function attachOptionIsDisabledIfLoopProbeProvided(): void
    {
        $settings =
            $this->getTesteeInstance(loopProbe: $this->getLoopProbeMock())
                ->build()
        ;

        self::assertInstanceOf(LegacySpinnerSettings::class, $settings);

        self::assertSame(OptionAttach::ENABLED, $settings->getAttachOption());
        self::assertSame(OptionInitialization::ENABLED, $settings->getInitializationOption());
    }

}
