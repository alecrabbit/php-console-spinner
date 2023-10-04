<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Legacy;

use AlecRabbit\Spinner\Core\Config\Legacy\LegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\LegacyWidgetConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
final class LegacySpinnerConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetConfig = new LegacyWidgetConfig();
        $config = new LegacySpinnerConfig($widgetConfig);
        self::assertSame($widgetConfig, $config->getWidgetConfig());
    }
}
