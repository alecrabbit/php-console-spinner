<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Legacy\LegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use Error;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersSetupTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetup = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySignalHandlersSetup::class, $loopSetup);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?ILegacyLoopSettings $settings = null,
    ): ILegacySignalHandlersSetup {
        return
            new LegacySignalHandlersSetup(
                loop: $loop ?? $this->getLoopMock(),
                loopSettings: $settings ?? $this->getLegacyLoopSettingsMock(),
            );
    }

    #[Test]
    public function doesNothingWithDefaults(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::never())
            ->method('autoStart')
        ;
        $loop
            ->expects(self::never())
            ->method('onSignal')
        ;

        $this->getTesteeInstance($loop)
            ->setup($this->getDriverMock())
        ;
    }

    #[Test]
    public function does(): void
    {
        $loop = $this->getLoopMock();

        $settings = $this->getLegacyLoopSettingsMock();
        $settings
            ->expects(self::once())
            ->method('isLoopAvailable')
            ->willReturn(true)
        ;
        $settings
            ->expects(self::once())
            ->method('isSignalProcessingAvailable')
            ->willReturn(true)
        ;
        $settings
            ->expects(self::once())
            ->method('isAttachHandlersEnabled')
            ->willReturn(true)
        ;

        if (!defined('SIGINT')) {
            $this->expectException(Error::class);
            $this->expectExceptionMessage('Undefined constant');
        } else {
            $loop
                ->expects(self::once())
                ->method('onSignal')
            ;
        }

        $loopSetup = $this->getTesteeInstance(
            loop: $loop,
            settings: $settings,
        );

        $loopSetup->setup($this->getDriverMock());
    }
}
