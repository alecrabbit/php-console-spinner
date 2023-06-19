<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\LoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStarterTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $autoStarter = $this->getTesteeInstance();

        self::assertInstanceOf(LoopAutoStarter::class, $autoStarter);
    }

    public function getTesteeInstance(
        ?ILoopSettings $settings = null,
    ): ILoopAutoStarter {
        return
            new LoopAutoStarter(
                settings: $settings ?? $this->getLoopSettingsMock(),
            );
    }

    #[Test]
    public function canDoNothing(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::never())
            ->method('autoStart')
        ;

        $autoStarter = $this->getTesteeInstance();

        $autoStarter->setup($loop);
    }

    #[Test]
    public function canDoSetup(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::once())
            ->method('autoStart')
        ;

        $settings = $this->getLoopSettingsMock();
        $settings
            ->expects(self::once())
            ->method('isLoopAvailable')
            ->willReturn(true)
        ;
        $settings
            ->expects(self::once())
            ->method('isAutoStartEnabled')
            ->willReturn(true)
        ;

        $autoStarter = $this->getTesteeInstance(
            settings: $settings,
        );

        $autoStarter->setup($loop);
    }
}
