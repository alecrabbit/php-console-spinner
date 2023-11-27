<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(DriverConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?IDriverMessages $driverMessages = null,
        ?DriverMode $driverMode = null,
    ): IDriverConfig {
        return
            new DriverConfig(
                driverMessages: $driverMessages ?? $this->getDriverMessagesMock(),
                driverMode: $driverMode ?? DriverMode::DISABLED,
            );
    }

    protected function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    #[Test]
    public function canGetDriverMode(): void
    {
        $driverMode = DriverMode::ENABLED;

        $config = $this->getTesteeInstance(
            driverMode: $driverMode,
        );

        self::assertSame($driverMode, $config->getDriverMode());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(IDriverConfig::class, $config->getIdentifier());
    }

}
