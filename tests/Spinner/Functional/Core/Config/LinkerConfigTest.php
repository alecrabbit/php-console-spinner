<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\LinkerConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class LinkerConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?LinkerMode $linkerMode = null,
    ): ILinkerConfig {
        return
            new LinkerConfig(
                linkerMode: $linkerMode ?? LinkerMode::DISABLED,
            );
    }

    #[Test]
    public function canGetLinkerMode(): void
    {
        $linkerMode = LinkerMode::ENABLED;

        $config = $this->getTesteeInstance(
            linkerMode: $linkerMode,
        );

        self::assertSame($linkerMode, $config->getLinkerMode());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(ILinkerConfig::class, $config->getIdentifier());
    }

}
