<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetConfig = new WidgetConfig();
        $config = new SpinnerConfig($widgetConfig);
        self::assertSame($widgetConfig, $config->getWidgetConfig());
    }
}
