<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\DetectedSettingsFactory;
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

    private function getStylingMethodDetectorMock(
        ?StylingOption $stylingOpion = null,
    ): MockObject&IStylingMethodDetector {
        return $this->createConfiguredMock(
            IStylingMethodDetector::class,
            [
                'getSupportValue' => $stylingOpion ?? StylingOption::ANSI8,
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
    public function canCreate(): void
    {
        $factory = $this->getTesteeInstance();

        $settings = $factory->create();

        self::assertInstanceOf(Settings::class, $settings);
    }
}
