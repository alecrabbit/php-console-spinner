<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\LegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStarterTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $autoStarter = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyLoopAutoStarter::class, $autoStarter);
    }

    public function getTesteeInstance(
        ?ILegacyLoopSettings $settings = null,
    ): ILegacyLoopAutoStarter {
        return
            new LegacyLoopAutoStarter(
                settings: $settings ?? $this->getLegacyLoopSettingsMock(),
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

        $settings = $this->getLegacyLoopSettingsMock();
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
