<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Builder\AuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AuxConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $runMethodMode = RunMethodMode::SYNCHRONOUS;
        $normalizerMode = NormalizerMode::STILL;

        $config = $configBuilder
            ->withRunMethodMode($runMethodMode)
            ->withNormalizerMode($normalizerMode)
            ->build()
        ;

        self::assertInstanceOf(AuxConfig::class, $config);
        self::assertSame($runMethodMode, $config->getRunMethodMode());
        self::assertSame($normalizerMode, $config->getNormalizerMode());
    }

    protected function getTesteeInstance(): IAuxConfigBuilder
    {
        return
            new AuxConfigBuilder();
    }

}
