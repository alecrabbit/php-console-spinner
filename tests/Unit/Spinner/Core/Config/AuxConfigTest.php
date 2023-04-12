<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

class AuxConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function simpleTest(): void
    {
        $interval = $this->getIntervalMock();
        $normalizerMode = OptionNormalizerMode::SMOOTH;
        $outputStream = STDERR;
        $cursorOption = OptionCursor::VISIBLE;
        $optionStyleMode = OptionStyleMode::ANSI24;

        $config =
            new AuxConfig(
                $interval,
                $normalizerMode,
                $cursorOption,
                $optionStyleMode,
                $outputStream,
            );
        self::assertSame($interval, $config->getInterval());
        self::assertSame($normalizerMode, $config->getNormalizerMode());
        self::assertSame($cursorOption, $config->getCursorOption());
        self::assertSame($optionStyleMode, $config->getStyleModeOption());
        self::assertSame($outputStream, $config->getOutputStream());
    }

}
