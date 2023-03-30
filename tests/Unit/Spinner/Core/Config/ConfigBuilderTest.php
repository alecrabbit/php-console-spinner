<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $configBuilder = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IConfigBuilder {
        return
            new ConfigBuilder(
                container: $container ?? $this->getContainerMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function canBuildDefaultConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(new DefaultsProvider())
        ;

        $configBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $config = $configBuilder->build();
    }

    #[Test]
    public function canBuildWithDriverConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(new DefaultsProvider())
        ;

        $configBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $driverConfig = new DriverConfig('interrupted', 'finished');

        $config = $configBuilder->withDriverConfig($driverConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithLoopConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(new DefaultsProvider())
        ;

        $configBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $loopConfig =
            new LoopConfig(
                OptionRunMode::SYNCHRONOUS,
                OptionAutoStart::DISABLED,
                OptionSignalHandlers::DISABLED,
            );

        $config = $configBuilder->withLoopConfig($loopConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithSpinnerConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(new DefaultsProvider())
        ;

        $configBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $spinnerConfig =
            new SpinnerConfig(
                OptionInitialization::DISABLED,
            );

        $config = $configBuilder->withSpinnerConfig($spinnerConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithRootWidgetConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(new DefaultsProvider())
        ;

        $configBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $frame = $this->createMock(IFrame::class);
        $widgetConfig = new WidgetConfig($frame, $frame);

        $config = $configBuilder->withRootWidgetConfig($widgetConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

}
