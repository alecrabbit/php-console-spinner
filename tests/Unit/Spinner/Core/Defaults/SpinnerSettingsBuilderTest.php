<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAttach;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\SpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\SpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerSettingsBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        self::assertTrue(true);

        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(
        ?ILoopProbe $loopProbe = null,
    ): ISpinnerSettingsBuilder {
        return
            new SpinnerSettingsBuilder(
                loopProbe: $loopProbe,
            );
    }

    #[Test]
    public function attachOptionIsDisabledIfLoopProbeIsNull(): void
    {
        self::assertTrue(true);

        $settings = $this->getTesteeInstance()->build();

        self::assertInstanceOf(SpinnerSettings::class, $settings);

        self::assertSame(OptionAttach::DISABLED, $settings->getAttachOption());
        self::assertSame(OptionInitialization::ENABLED, $settings->getInitializationOption());
    }

    #[Test]
    public function attachOptionIsDisabledIfLoopProbeProvided(): void
    {
        self::assertTrue(true);

        $settings =
            $this->getTesteeInstance(loopProbe: $this->getLoopProbeMock())
                ->build()
        ;

        self::assertInstanceOf(SpinnerSettings::class, $settings);

        self::assertSame(OptionAttach::ENABLED, $settings->getAttachOption());
        self::assertSame(OptionInitialization::ENABLED, $settings->getInitializationOption());
    }

}
