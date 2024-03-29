<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\GeneralConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GeneralConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(GeneralConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?RunMethodMode $runMethodMode = null,
    ): IGeneralConfig {
        return
            new GeneralConfig(
                runMethodMode: $runMethodMode ?? RunMethodMode::ASYNC,
            );
    }

    #[Test]
    public function canGetRunMethodMode(): void
    {
        $runMethodMode = RunMethodMode::SYNCHRONOUS;

        $config = $this->getTesteeInstance(
            runMethodMode: $runMethodMode,
        );

        self::assertSame($runMethodMode, $config->getRunMethodMode());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(IGeneralConfig::class, $config->getIdentifier());
    }
}
