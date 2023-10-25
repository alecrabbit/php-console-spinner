<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AuxSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?RunMethodOption $runMethodOption = null,
        ?NormalizerOption $normalizerOption = null,
    ): IAuxSettings {
        return
            new AuxSettings(
                runMethodOption: $runMethodOption ?? RunMethodOption::AUTO,
                normalizerOption: $normalizerOption ?? NormalizerOption::AUTO,
            );
    }

    #[Test]
    public function canGetInterface(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IAuxSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetRunMethodOption(): void
    {
        $runMethodOption = RunMethodOption::ASYNC;

        $settings = $this->getTesteeInstance(
            runMethodOption: $runMethodOption,
        );

        self::assertEquals($runMethodOption, $settings->getRunMethodOption());
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
