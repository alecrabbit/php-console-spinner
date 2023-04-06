<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

class WidgetConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function simpleTest(): void
    {
        $leadingSpacer = $this->getFrameStub();
        $trailingSpacer = $this->getFrameStub();
        $stylePattern = $this->getPatternStub();
        $charPattern = $this->getPatternStub();
        $config =
            new WidgetConfig(
                $leadingSpacer,
                $trailingSpacer,
                $stylePattern,
                $charPattern,
            );
        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }
}
