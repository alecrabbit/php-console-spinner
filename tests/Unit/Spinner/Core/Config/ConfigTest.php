<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;

class ConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function simpleTest(): void
    {
        $auxConfig = $this->getAuxConfigStub();
        $driverConfig = $this->getDriverConfigStub();
        $rootWidgetConfig = $this->getWidgetConfigStub();
        $loopConfig = $this->getLoopConfigStub();
        $spinnerConfig = $this->getSpinnerConfigStub();

        $config =
            new Config(
                $auxConfig,
                $driverConfig,
                $loopConfig,
                $spinnerConfig,
                $rootWidgetConfig,
            );
        self::assertSame($auxConfig, $config->getAuxConfig());
        self::assertSame($driverConfig, $config->getDriverConfig());
        self::assertSame($loopConfig, $config->getLoopConfig());
        self::assertSame($spinnerConfig, $config->getSpinnerConfig());
        self::assertSame($rootWidgetConfig, $config->getRootWidgetConfig());

    }

    protected function getAuxConfigStub(): Stub&IAuxConfig
    {
        return $this->createStub(IAuxConfig::class);
    }

    protected function getDriverConfigStub(): Stub&IDriverConfig
    {
        return $this->createStub(IDriverConfig::class);
    }

    protected function getSpinnerConfigStub(): Stub&ISpinnerConfig
    {
        return $this->createStub(ISpinnerConfig::class);
    }


}
