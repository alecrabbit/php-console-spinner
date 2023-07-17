<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
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
        ?NormalizerMethodMode $normalizerMode = null,
    ): IAuxSettings {
        return
            new AuxSettings(
                normalizerMethodMode: $normalizerMode ?? NormalizerMethodMode::STILL,
            );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $normalizerMethodMode = NormalizerMethodMode::SMOOTH;

        $auxSettings = $this->getTesteeInstance(
            normalizerMode: $normalizerMethodMode,
        );

        self::assertInstanceOf(AuxSettings::class, $auxSettings);
        self::assertSame($normalizerMethodMode, $auxSettings->getNormalizerMethodMode());

        $normalizerMethodMode = NormalizerMethodMode::PERFORMANCE;
        $auxSettings->setNormalizerMethodMode($normalizerMethodMode);
        self::assertSame($normalizerMethodMode, $auxSettings->getNormalizerMethodMode());
    }
}
