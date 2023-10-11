<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\LoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetup::class, $driverBuilder);
    }

    public function getTesteeInstance(
        ?ILoopConfig $loopConfig = null
    ): ILoopSetup {
        return
            new LoopSetup(
                loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
            );
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

        $loopSetup = $this->getTesteeInstance(
            loopConfig: $loopConfig,
        );

        $loopSetup->setup($loop);
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

}
