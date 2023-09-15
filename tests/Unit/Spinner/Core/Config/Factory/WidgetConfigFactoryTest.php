<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IConfigProvider $configProvider = null,
    ): IWidgetConfigFactory {
        return
            new WidgetConfigFactory(
                configProvider: $configProvider ?? $this->getConfigProviderMock(),
            );
    }

    private function getConfigProviderMock(): MockObject&IConfigProvider
    {
        return $this->createMock(IConfigProvider::class);
    }
}
