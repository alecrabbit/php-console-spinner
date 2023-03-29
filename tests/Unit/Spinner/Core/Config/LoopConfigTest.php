<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoopConfigTest extends TestCase
{
    #[Test]
    public function simpleTest(): void
    {
        $config =
            new LoopConfig(
                OptionRunMode::SYNCHRONOUS,
                OptionAutoStart::DISABLED,
                OptionSignalHandlers::DISABLED,
            );
        self::assertFalse($config->isAsynchronous());
        self::assertFalse($config->isEnabledAutoStart());
        self::assertFalse($config->areEnabledSignalHandlers());
    }
}
