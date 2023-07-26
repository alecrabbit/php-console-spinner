<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AuxConfigTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?RunMethodMode $runMethodMode = null,
        ?LoopAvailabilityMode $loopAvailabilityMode = null,
        ?NormalizerMethodMode $normalizerMethodMode = null,
    ): IAuxConfig {
        return
            new AuxConfig(
                runMethodMode: $runMethodMode ?? RunMethodMode::ASYNC,
                loopAvailabilityMode: $loopAvailabilityMode ?? LoopAvailabilityMode::NONE,
                normalizerMethodMode: $normalizerMethodMode ?? NormalizerMethodMode::STILL,
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
    public function canGetLoopAvailabilityMode(): void
    {
        $loopAvailabilityMode = LoopAvailabilityMode::NONE;

        $config = $this->getTesteeInstance(
            loopAvailabilityMode: $loopAvailabilityMode,
        );

        self::assertSame($loopAvailabilityMode, $config->getLoopAvailabilityMode());
    }

    #[Test]
    public function canGetNormalizerMethodMode(): void
    {
        $normalizerMethodMode = NormalizerMethodMode::STILL;

        $config = $this->getTesteeInstance(
            normalizerMethodMode: $normalizerMethodMode,
        );

        self::assertSame($normalizerMethodMode, $config->getNormalizerMethodMode());
    }
}
