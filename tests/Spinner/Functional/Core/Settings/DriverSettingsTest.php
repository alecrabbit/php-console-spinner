<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\DriverOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IMessages;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?IMessages $messages = null,
        ?DriverOption $driverOption = null,
    ): IDriverSettings {
        return
            new DriverSettings(
                messages: $messages,
                driverOption: $driverOption ?? DriverOption::AUTO,
            );
    }

    #[Test]
    public function canGetDriverOption(): void
    {
        $driverOption = DriverOption::DISABLED;

        $settings = $this->getTesteeInstance(
            driverOption: $driverOption,
        );

        self::assertSame($driverOption, $settings->getDriverOption());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IDriverSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetMessages(): void
    {
        $messages = $this->getMessagesMock();

        $settings = $this->getTesteeInstance(messages: $messages);

        self::assertSame($messages, $settings->getMessages());
    }

    protected function getMessagesMock(): MockObject&IMessages
    {
        return $this->createMock(IMessages::class);
    }
}
