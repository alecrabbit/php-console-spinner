<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use Error;
use PHPUnit\Framework\Attributes\Test;

final class LoopSetupTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSetup = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetup::class, $loopSetup);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?ILoopSettings $settings = null,
    ): ILoopSetup {
        return
            new LoopSetup(
                loop: $loop ?? $this->getLoopMock(),
                settings: $settings ?? $this->getLoopSettingsMock(),
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
