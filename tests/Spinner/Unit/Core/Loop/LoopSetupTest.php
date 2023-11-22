<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Loop;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDisabledDriverDetector;
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
        ?IDisabledDriverDetector $disabledDriverDetector = null,
    ): ILoopSetup {
        return
            new LoopSetup(
                loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
                disabledDriverDetector: $disabledDriverDetector ?? $this->getDisabledDriverDetectorMock(),
            );
    }
    private function getDisabledDriverDetectorMock(): MockObject&IDisabledDriverDetector
    {
        return $this->createMock(IDisabledDriverDetector::class);
    }

    private function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
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

        $disabledDriverDetector = $this->getDisabledDriverDetectorMock();
        $disabledDriverDetector
            ->expects(self::once())
            ->method('isDisabled')
            ->willReturn(false);

        $loopSetup = $this->getTesteeInstance(
            loopConfig: $loopConfig,
            disabledDriverDetector: $disabledDriverDetector,
        );

        $loopSetup->setup($loop);
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

}
