<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\ExecutionOption;
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
        ?ExecutionOption $executionOption = null,
    ): IGeneralSettings {
        return
            new GeneralSettings(
                executionOption: $executionOption ?? ExecutionOption::AUTO,
            );
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IGeneralSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetExecutionOption(): void
    {
        $executionOption = ExecutionOption::ASYNC;

        $settings = $this->getTesteeInstance(
            executionOption: $executionOption,
        );

        self::assertEquals($executionOption, $settings->getExecutionOption());
    }
}
