<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISignalHandlersContainer;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(LoopConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?AutoStartMode $autoStartMode = null,
        ?SignalHandlingMode $signalHandlersMode = null,
        ?ISignalHandlersContainer $signalHandlersContainer = null,
    ): ILoopConfig {
        return
            new LoopConfig(
                autoStartMode: $autoStartMode ?? AutoStartMode::DISABLED,
                signalHandlersMode: $signalHandlersMode ?? SignalHandlingMode::DISABLED,
                signalHandlersContainer: $signalHandlersContainer ?? $this->getSignalHandlersContainerMock(),
            );
    }

    private function getSignalHandlersContainerMock(): MockObject&ISignalHandlersContainer
    {
        return $this->createMock(ISignalHandlersContainer::class);
    }

    #[Test]
    public function canGetAutoStartMode(): void
    {
        $autoStartMode = AutoStartMode::ENABLED;

        $config = $this->getTesteeInstance(
            autoStartMode: $autoStartMode,
        );

        self::assertSame($autoStartMode, $config->getAutoStartMode());
    }

    #[Test]
    public function canGetSignalHandlingMode(): void
    {
        $signalHandlersMode = SignalHandlingMode::ENABLED;

        $config = $this->getTesteeInstance(
            signalHandlersMode: $signalHandlersMode,
        );

        self::assertSame($signalHandlersMode, $config->getSignalHandlingMode());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(ILoopConfig::class, $config->getIdentifier());
    }
}
