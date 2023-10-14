<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingSupportDetector;
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
        ?IColorSupportDetector $colorSupportDetector = null,
        ?ISignalProcessingSupportDetector $signalHandlingDetector = null,
    ): IDetectedSettingsFactory {
        return
            new DetectedSettingsFactory(
                loopSupportDetector: $loopAvailabilityDetector ?? $this->getLoopAvailabilityDetectorMock(),
                colorSupportDetector: $colorSupportDetector ?? $this->getColorSupportDetectorMock(),
                signalProcessingSupportDetector: $signalHandlingDetector ?? $this->getSignalProcessingSupportDetectorMock(
            ),
            );
    }

    private function getLoopAvailabilityDetectorMock(): MockObject&ILoopSupportDetector
    {
        return $this->createMock(ILoopSupportDetector::class);
    }

    private function getColorSupportDetectorMock(
        ?StylingMethodOption $stylingMethodOption = null,
    ): MockObject&IColorSupportDetector {
        return $this->createConfiguredMock(
            IColorSupportDetector::class,
            [
                'getSupportValue' => $stylingMethodOption ?? StylingMethodOption::ANSI8,
            ]
        );
    }

    private function getSignalProcessingSupportDetectorMock(
        ?SignalHandlersOption $signalHandlersOption = null,
    ): MockObject&ISignalProcessingSupportDetector {
        return $this->createConfiguredMock(
            ISignalProcessingSupportDetector::class,
            [
                'getSupportValue' => $signalHandlersOption ?? SignalHandlersOption::DISABLED,
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
