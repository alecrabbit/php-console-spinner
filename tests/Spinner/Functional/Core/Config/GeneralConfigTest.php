<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
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
        ?ExecutionMode $executionMode = null,
    ): IGeneralConfig {
        return
            new GeneralConfig(
                executionMode: $executionMode ?? ExecutionMode::ASYNC,
            );
    }

    #[Test]
    public function canGetExecutionMode(): void
    {
        $executionMode = ExecutionMode::SYNCHRONOUS;

        $config = $this->getTesteeInstance(
            executionMode: $executionMode,
        );

        self::assertSame($executionMode, $config->getExecutionMode());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(IGeneralConfig::class, $config->getIdentifier());
    }
}
