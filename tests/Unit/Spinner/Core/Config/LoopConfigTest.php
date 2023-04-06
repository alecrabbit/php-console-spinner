<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoopConfigTest extends TestCase
{
    #[Test]
    public function simpleTest(): void
    {
        $runModeOption = OptionRunMode::SYNCHRONOUS;
        $config =
            new LoopConfig(
                $runModeOption,
                OptionAutoStart::DISABLED,
                OptionAttachHandlers::DISABLED,
            );
        self::assertFalse($config->isRunModeAsynchronous());
        self::assertFalse($config->isEnabledAutoStart());
        self::assertFalse($config->isEnabledAttachHandlers());
        self::assertSame($runModeOption, $config->getRunModeOption());
    }
}
