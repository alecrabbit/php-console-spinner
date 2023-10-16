<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AuxConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?RunMethodMode $runMethodMode = null,
        ?NormalizerMode $normalizerMode = null,
    ): IAuxConfig {
        return
            new AuxConfig(
                runMethodMode: $runMethodMode ?? RunMethodMode::ASYNC,
                normalizerMode: $normalizerMode ?? NormalizerMode::STILL,
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
    public function canGetNormalizerMode(): void
    {
        $normalizerMode = NormalizerMode::STILL;

        $config = $this->getTesteeInstance(
            normalizerMode: $normalizerMode,
        );

        self::assertSame($normalizerMode, $config->getNormalizerMode());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(IAuxConfig::class, $config->getIdentifier());
    }
}
