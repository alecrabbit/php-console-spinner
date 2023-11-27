<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GeneralSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(GeneralSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?RunMethodOption $runMethodOption = null,
    ): IGeneralSettings {
        return
            new GeneralSettings(
                runMethodOption: $runMethodOption ?? RunMethodOption::AUTO,
            );
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IGeneralSettings::class, $settings->getIdentifier());
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
}
