<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Loop;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartEnabledResolver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\LoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetup = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetup::class, $loopSetup);
    }

    public function getTesteeInstance(
        ?ILoopConfig $loopConfig = null,
        ?IDriverModeDetector $driverModeDetector = null,
        ?IAutoStartEnabledResolver $autoStartResolver = null,
    ): ILoopSetup {
        return
            new LoopSetup(
                loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
                driverModeDetector: $driverModeDetector ?? $this->getDriverModeDetectorMock(),
            );
    }

    private function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

    private function getDriverModeDetectorMock(): MockObject&IDriverModeDetector
    {
        return $this->createMock(IDriverModeDetector::class);
    }

    #[Test]
    public function canSetup(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::once())
            ->method('autoStart')
        ;

        $loopConfig = $this->getLoopConfigMock();
        $loopConfig
            ->expects(self::once())
            ->method('getAutoStartMode')
            ->willReturn(AutoStartMode::ENABLED)
        ;

        $driverModeDetector = $this->getDriverModeDetectorMock();
        $driverModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $loopSetup = $this->getTesteeInstance(
            loopConfig: $loopConfig,
            driverModeDetector: $driverModeDetector,
        );

        $loopSetup->setup($loop);
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

}
