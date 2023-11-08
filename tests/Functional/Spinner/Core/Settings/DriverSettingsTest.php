<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

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
    ): IDriverSettings {
        return
            new DriverSettings(
                messages: $messages,
            );
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
