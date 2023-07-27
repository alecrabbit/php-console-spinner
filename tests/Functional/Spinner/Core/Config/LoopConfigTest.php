<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

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
        ?SignalHandlersMode $signalHandlersMode = null,
    ): ILoopConfig {
        return
            new LoopConfig(
                autoStartMode: $autoStartMode ?? AutoStartMode::DISABLED,
                signalHandlersMode: $signalHandlersMode ?? SignalHandlersMode::DISABLED,
            );
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
    public function canGetSignalHandlersMode(): void
    {
        $signalHandlersMode = SignalHandlersMode::ENABLED;

        $config = $this->getTesteeInstance(
            signalHandlersMode: $signalHandlersMode,
        );

        self::assertSame($signalHandlersMode, $config->getSignalHandlersMode());
    }
}
