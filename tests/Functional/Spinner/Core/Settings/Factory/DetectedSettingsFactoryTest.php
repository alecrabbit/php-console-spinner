<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Factory\DetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DetectedSettingsFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DetectedSettingsFactory::class, $factory);
    }

    protected function getTesteeInstance(
        ?ILoopSupportDetector $loopAvailabilityDetector = null,
        ?IStylingMethodDetector $colorSupportDetector = null,
        ?ISignalHandlingSupportDetector $signalHandlingDetector = null,
    ): IDetectedSettingsFactory {
        return
            new DetectedSettingsFactory(
                loopSupportDetector: $loopAvailabilityDetector ?? $this->getLoopAvailabilityDetectorMock(),
                colorSupportDetector: $colorSupportDetector ?? $this->getStylingMethodDetectorMock(),
                signalProcessingSupportDetector: $signalHandlingDetector ?? $this->getSignalProcessingSupportDetectorMock(
            ),
            );
    }

    private function getLoopAvailabilityDetectorMock(): MockObject&ILoopSupportDetector
    {
        return $this->createMock(ILoopSupportDetector::class);
    }

    private function getStylingMethodDetectorMock(?StylingMethodOption $stylingMethodOption = null
    ): MockObject&IStylingMethodDetector {
        return $this->createConfiguredMock(
            IStylingMethodDetector::class,
            [
                'getSupportValue' => $stylingMethodOption ?? StylingMethodOption::NONE,
            ]
        );
    }

    private function getSignalProcessingSupportDetectorMock(
        ?SignalHandlingOption $signalHandlersOption = null,
    ): MockObject&ISignalHandlingSupportDetector {
        return $this->createConfiguredMock(
            ISignalHandlingSupportDetector::class,
            [
                'getSupportValue' => $signalHandlersOption ?? SignalHandlingOption::DISABLED,
            ]
        );
    }

    #[Test]
    public function canCreateFilled(): void
    {
        $loopAvailabilityDetector = $this->getLoopAvailabilityDetectorMock();
        $loopAvailabilityDetector
            ->expects(self::exactly(3))
            ->method('getSupportValue')
            ->willReturn(true)
        ;

        $signalHandlersOption =
            extension_loaded('pcntl')
                ? SignalHandlingOption::ENABLED
                : SignalHandlingOption::DISABLED;

        $stylingMethodOption = StylingMethodOption::ANSI24;

        $colorSupportDetector =
            $this->getStylingMethodDetectorMock($stylingMethodOption);

        $signalHandlingDetector =
            $this->getSignalProcessingSupportDetectorMock($signalHandlersOption);

        $factory = $this->getTesteeInstance(
            loopAvailabilityDetector: $loopAvailabilityDetector,
            colorSupportDetector: $colorSupportDetector,
            signalHandlingDetector: $signalHandlingDetector,
        );

        $settings = $factory->create();

        self::assertInstanceOf(Settings::class, $settings);

        self::assertNull($settings->get(IWidgetSettings::class));
        self::assertNull($settings->get(IRootWidgetSettings::class));

        $auxSettings = $settings->get(IAuxSettings::class);
        $linkerSettings = $settings->get(ILinkerSettings::class);
        $loopSettings = $settings->get(ILoopSettings::class);
        $outputSettings = $settings->get(IOutputSettings::class);

        self::assertInstanceOf(AuxSettings::class, $auxSettings);
        self::assertInstanceOf(LinkerSettings::class, $linkerSettings);
        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertInstanceOf(OutputSettings::class, $outputSettings);

        self::assertSame(RunMethodOption::ASYNC, $auxSettings->getRunMethodOption());
        self::assertSame(LinkerOption::ENABLED, $linkerSettings->getLinkerOption());
        self::assertSame(AutoStartOption::ENABLED, $loopSettings->getAutoStartOption());
        self::assertSame($signalHandlersOption, $loopSettings->getSignalHandlingOption());

        self::assertSame($signalHandlersOption, $loopSettings->getSignalHandlingOption());
        self::assertSame($stylingMethodOption, $outputSettings->getStylingMethodOption());
    }
}
