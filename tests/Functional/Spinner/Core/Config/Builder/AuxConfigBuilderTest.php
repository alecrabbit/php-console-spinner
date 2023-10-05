<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
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
        $normalizerMethodMode = NormalizerMethodMode::STILL;

        $config = $configBuilder
            ->withRunMethodMode($runMethodMode)
            ->withNormalizerMethodMode($normalizerMethodMode)
            ->build()
        ;

        self::assertInstanceOf(AuxConfig::class, $config);
        self::assertSame($runMethodMode, $config->getRunMethodMode());
        self::assertSame($normalizerMethodMode, $config->getNormalizerMethodMode());
    }

    protected function getTesteeInstance(): IAuxConfigBuilder
    {
        return
            new AuxConfigBuilder();
    }

}
