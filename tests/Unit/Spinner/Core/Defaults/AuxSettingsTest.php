<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyAuxSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AuxSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $auxSettings = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyAuxSettings::class, $auxSettings);
    }

    public function getTesteeInstance(
        ?NormalizerMethodMode $normalizerMode = null,
    ): ILegacyAuxSettings {
        return
            new LegacyAuxSettings(
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

        self::assertInstanceOf(LegacyAuxSettings::class, $auxSettings);
        self::assertSame($normalizerMethodMode, $auxSettings->getNormalizerMethodMode());

        $normalizerMethodMode = NormalizerMethodMode::PERFORMANCE;
        $auxSettings->setNormalizerMethodMode($normalizerMethodMode);
        self::assertSame($normalizerMethodMode, $auxSettings->getNormalizerMethodMode());
    }
}
