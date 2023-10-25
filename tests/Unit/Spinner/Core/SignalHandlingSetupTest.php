<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;
use AlecRabbit\Spinner\Core\SignalHandlingSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SignalHandlingSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverLinker = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlingSetup::class, $driverLinker);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?ILoopConfig $loopConfig = null,
    ): ISignalHandlingSetup {
        return new SignalHandlingSetup(
            loop: $loop ?? $this->getLoopMock(),
            loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
        );
    }

    private function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

    private function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }
}
