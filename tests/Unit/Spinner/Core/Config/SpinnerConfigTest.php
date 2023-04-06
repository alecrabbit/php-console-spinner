<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Option\OptionAttach;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

class SpinnerConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function optionsDisabled(): void
    {
        $initializationOption = OptionInitialization::DISABLED;
        $attachOption = OptionAttach::DISABLED;

        $config =
            new SpinnerConfig(
                $initializationOption,
                $attachOption,
            );
        self::assertFalse($config->isEnabledInitialization());
        self::assertFalse($config->isEnabledAttach());
    }

    #[Test]
    public function optionsEnabled(): void
    {
        $initializationOption = OptionInitialization::ENABLED;
        $attachOption = OptionAttach::ENABLED;

        $config =
            new SpinnerConfig(
                $initializationOption,
                $attachOption,
            );
        self::assertTrue($config->isEnabledInitialization());
        self::assertTrue($config->isEnabledAttach());
    }
}
