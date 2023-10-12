<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\RuntimeWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WorkingWidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(RuntimeWidgetConfigFactory::class, $factory);
    }

    private function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    public function getTesteeInstance(
        ?IWidgetConfig $widgetConfig = null,
    ): IWidgetConfigFactory {
        return
            new RuntimeWidgetConfigFactory(
                widgetConfig: $widgetConfig ?? $this->getWidgetConfigMock(),
            );
    }
}
