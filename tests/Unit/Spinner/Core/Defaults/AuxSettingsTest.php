<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\NormalizerMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AuxSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $auxSettings = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettings::class, $auxSettings);
    }

    public function getTesteeInstance(
        ?NormalizerMethodOption $optionNormalizerMode = null,
    ): IAuxSettings {
        return new AuxSettings(
            optionNormalizerMode: $optionNormalizerMode ?? NormalizerMethodOption::STILL,
        );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $optionNormalizerMode = NormalizerMethodOption::SMOOTH;

        $auxSettings = $this->getTesteeInstance(
            optionNormalizerMode: $optionNormalizerMode,
        );

        self::assertInstanceOf(AuxSettings::class, $auxSettings);
        self::assertSame($optionNormalizerMode, $auxSettings->getOptionNormalizerMode());

        $optionNormalizerMode = NormalizerMethodOption::PERFORMANCE;
        $auxSettings->setOptionNormalizerMode($optionNormalizerMode);
        self::assertSame($optionNormalizerMode, $auxSettings->getOptionNormalizerMode());
    }
}
