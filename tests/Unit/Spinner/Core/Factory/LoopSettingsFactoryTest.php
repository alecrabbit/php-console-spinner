<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\LoopSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyLoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory\Stub\LoopProbeStub;
use PHPUnit\Framework\Attributes\Test;

final class LoopSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSettingsFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettingsFactory::class, $loopSettingsFactory);
    }

    public function getTesteeInstance(
        ?ILoopProbe $loopProbe = null,
        ?ILegacySignalProcessingLegacyProbe $signalProcessingProbe = null,
    ): ILoopSettingsFactory {
        return new LoopSettingsFactory(
            loopProbe: $loopProbe,
            signalProcessingProbe: $signalProcessingProbe,
        );
    }

    #[Test]
    public function allSettingsAreDisabledIfLoopProbeIsNull(): void
    {
        $loopSettings = $this->getTesteeInstance()->createLoopSettings();

        self::assertInstanceOf(LegacyLoopSettings::class, $loopSettings);

        self::assertFalse($loopSettings->isLoopAvailable());
        self::assertFalse($loopSettings->isAutoStartEnabled());
        self::assertFalse($loopSettings->isAttachHandlersEnabled());
        self::assertFalse($loopSettings->isSignalProcessingAvailable());
    }

    #[Test]
    public function allSettingsAreEnabledIfAllProbesAreProvided(): void
    {
        $signalProcessingProbe = $this->getSignalProcessingProbeMock();
        $signalProcessingProbe
            ->expects(self::once())
            ->method('isAvailable')
            ->willReturn(true)
        ;

        $loopSettings =
            $this->getTesteeInstance(
                loopProbe: $this->getLoopProbeStub(),
                signalProcessingProbe: $signalProcessingProbe,
            )
                ->createLoopSettings()
        ;

        self::assertInstanceOf(LegacyLoopSettings::class, $loopSettings);

        self::assertTrue($loopSettings->isLoopAvailable());
        self::assertTrue($loopSettings->isAutoStartEnabled());
        self::assertTrue($loopSettings->isAttachHandlersEnabled());
        self::assertTrue($loopSettings->isSignalProcessingAvailable());
    }

    protected function getLoopProbeStub(): ILoopProbe
    {
        return new LoopProbeStub();
    }

}
