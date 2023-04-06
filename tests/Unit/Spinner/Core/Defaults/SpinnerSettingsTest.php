<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAttach;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\SpinnerSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerSettings = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerSettings::class, $spinnerSettings);
        self::assertSame(OptionInitialization::DISABLED, $spinnerSettings->getInitializationOption());
        self::assertSame(OptionAttach::DISABLED, $spinnerSettings->getAttachOption());
    }

    public function getTesteeInstance(
        ?OptionInitialization $initializationOption = null,
        ?OptionAttach $attachOption = null,
    ): ISpinnerSettings {
        return
            new SpinnerSettings(
                initializationOption: $initializationOption ?? OptionInitialization::DISABLED,
                attachOption: $attachOption ?? OptionAttach::DISABLED,
            );
    }

    #[Test]
    public function canBeCreatedWithArguments(): void
    {
        $initializationOption = OptionInitialization::ENABLED;
        $attachOption = OptionAttach::ENABLED;

        $spinnerSettings = $this->getTesteeInstance($initializationOption, $attachOption);

        self::assertInstanceOf(SpinnerSettings::class, $spinnerSettings);
        self::assertSame($initializationOption, $spinnerSettings->getInitializationOption());
        self::assertSame($attachOption, $spinnerSettings->getAttachOption());
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $initializationOption = OptionInitialization::ENABLED;
        $attachOption = OptionAttach::ENABLED;

        $spinnerSettings = $this->getTesteeInstance();
        $spinnerSettings->setInitializationOption($initializationOption);
        $spinnerSettings->setAttachOption($attachOption);

        self::assertInstanceOf(SpinnerSettings::class, $spinnerSettings);
        self::assertSame($initializationOption, $spinnerSettings->getInitializationOption());
        self::assertSame($attachOption, $spinnerSettings->getAttachOption());
    }
}
