<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Config\NormalizerConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class NormalizerConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(NormalizerConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?NormalizerMode $normalizerMode = null,
    ): INormalizerConfig {
        return
            new NormalizerConfig(
                normalizerMode: $normalizerMode ?? NormalizerMode::STILL,
            );
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

        self::assertEquals(INormalizerConfig::class, $config->getIdentifier());
    }
}
