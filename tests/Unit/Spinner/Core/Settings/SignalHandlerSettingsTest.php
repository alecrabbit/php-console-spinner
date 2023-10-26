<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerSettings;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SignalHandlerSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlerSettings::class, $settings);
    }

    public function getTesteeInstance(
        ISignalHandlerCreator ...$creators
    ): ISignalHandlerSettings {
        return
            new SignalHandlerSettings(
                ...$creators
            );
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(ISignalHandlerSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetCreators(): void
    {
        $shc1 = $this->getSignalHandlerCreatorMock();
        $shc2 = $this->getSignalHandlerCreatorMock();

        $settings =
            $this->getTesteeInstance(
                $shc1,
                $shc2,
            );

        self::assertEquals([$shc1, $shc2], iterator_to_array($settings->getCreators()));
    }

    private function getSignalHandlerCreatorMock(): MockObject&ISignalHandlerCreator
    {
        return $this->createMock(ISignalHandlerCreator::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }
}
