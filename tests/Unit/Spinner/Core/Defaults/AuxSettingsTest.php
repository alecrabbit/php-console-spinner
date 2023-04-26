<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Defaults\AuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
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
        ?OptionNormalizerMode $optionNormalizerMode = null,
    ): IAuxSettings {
        return new AuxSettings(
            optionNormalizerMode: $optionNormalizerMode ?? OptionNormalizerMode::STILL,
        );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $optionNormalizerMode = OptionNormalizerMode::SMOOTH;

        $auxSettings = $this->getTesteeInstance(
            optionNormalizerMode: $optionNormalizerMode,
        );

        self::assertInstanceOf(AuxSettings::class, $auxSettings);
        self::assertSame($optionNormalizerMode, $auxSettings->getOptionNormalizerMode());

        $optionNormalizerMode = OptionNormalizerMode::PERFORMANCE;
        $auxSettings->setOptionNormalizerMode($optionNormalizerMode);
        self::assertSame($optionNormalizerMode, $auxSettings->getOptionNormalizerMode());
    }
}
