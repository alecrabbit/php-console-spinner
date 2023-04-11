<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;
use AlecRabbit\Spinner\Core\Defaults\LoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopSettingsBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(
        ?ILoopProbe $loopProbe = null,
    ): ILoopSettingsBuilder {
        return
            new LoopSettingsBuilder(
                loopProbe: $loopProbe,
            );
    }

    #[Test]
    public function allSettingsAreDisabledIfLoopProbeIsNull(): void
    {
        $loopSettings = $this->getTesteeInstance()->build();

        self::assertInstanceOf(LoopSettings::class, $loopSettings);

        self::assertFalse($loopSettings->isLoopAvailable());
        self::assertFalse($loopSettings->isAutoStartEnabled());
        self::assertFalse($loopSettings->isAttachHandlersEnabled());
    }

    #[Test]
    public function allSettingsAreEnabledIfLoopProbeIsProvided(): void
    {
        $loopSettings =
            $this->getTesteeInstance(
                loopProbe: $this->getLoopProbeMock()
            )
                ->build()
        ;

        self::assertInstanceOf(LoopSettings::class, $loopSettings);

        self::assertTrue($loopSettings->isLoopAvailable());
        self::assertTrue($loopSettings->isAutoStartEnabled());
        self::assertTrue($loopSettings->isAttachHandlersEnabled());
    }
}
