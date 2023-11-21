<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\INormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class NormalizerSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(NormalizerSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?NormalizerOption $normalizerOption = null,
    ): INormalizerSettings {
        return
            new NormalizerSettings(
                normalizerOption: $normalizerOption ?? NormalizerOption::AUTO,
            );
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(INormalizerSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetNormalizerOption(): void
    {
        $normalizerOption = NormalizerOption::BALANCED;

        $settings = $this->getTesteeInstance(
            normalizerOption: $normalizerOption,
        );

        self::assertEquals($normalizerOption, $settings->getNormalizerOption());
    }
}
