<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Probes;
use AlecRabbit\Tests\Functional\Spinner\Override\StaticProbeOverride;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class FacadeTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canGetSettings(): void
    {
        $settings = Facade::getSettings();

        self::assertInstanceOf(Settings::class, $settings);
    }

    #[Test]
    public function settingsObjectIsAlwaysSame(): void
    {
        $settings = Facade::getSettings();

        self::assertInstanceOf(Settings::class, $settings);

        self::assertSame($settings, Facade::getSettings());
        self::assertSame($settings, Facade::getSettings());
        self::assertSame($settings, Facade::getSettings());
    }
}
