<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Legacy\LegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\LegacyWidgetConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetConfig = new LegacyWidgetConfig();
        $config = new LegacySpinnerConfig($widgetConfig);
        self::assertSame($widgetConfig, $config->getWidgetConfig());
    }
}
