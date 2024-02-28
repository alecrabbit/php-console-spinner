<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Factory\RootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RuntimeRootWidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(RootWidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IRootWidgetConfig $widgetConfig = null,
    ): IRootWidgetConfigFactory {
        return
            new RootWidgetConfigFactory(
                rootWidgetConfig: $widgetConfig ?? $this->getRootWidgetConfigMock(),
            );
    }

    private function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

    #[Test]
    public function canCreateWithWidgetConfig(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $revolverConfig = $this->getWidgetRevolverConfigMock();

        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getWidgetRevolverConfig')
            ->willReturn($revolverConfig)
        ;

        $factory = $this->getTesteeInstance();

        $resultWidgetConfig = $factory->create($widgetConfig);

        self::assertSame($leadingSpacer, $resultWidgetConfig->getLeadingSpacer());
        self::assertSame($trailingSpacer, $resultWidgetConfig->getTrailingSpacer());
        self::assertSame($revolverConfig, $resultWidgetConfig->getWidgetRevolverConfig());
    }

    private function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    private function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    private function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    public function canCreateWithoutWidgetSettings(): void
    {
        $widgetConfig = $this->getRootWidgetConfigMock();

        $factory = $this->getTesteeInstance($widgetConfig);

        $result = $factory->create();

        self::assertSame($widgetConfig, $result);
    }

    #[Test]
    public function canCreateWithWidgetSettingsNullValues(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePalette = $this->getStylePaletteMock();
        $charPalette = $this->getCharPaletteMock();

        $widgetSettings = $this->getWidgetSettingsMock();

        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn(null)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn(null)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn(null)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn(null)
        ;

        $widgetConfig = $this->getRootWidgetConfigMock();
        $revolverConfig = $this->getRevolverConfigMock();
        $widgetRevolverConfig = $this->getWidgetRevolverConfigMock();
        $widgetRevolverConfig
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($stylePalette)
        ;
        $widgetRevolverConfig
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn($charPalette)
        ;
        $widgetRevolverConfig
            ->expects(self::once())
            ->method('getRevolverConfig')
            ->willReturn($revolverConfig)
        ;

        $widgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getWidgetRevolverConfig')
            ->willReturn($widgetRevolverConfig)
        ;


        $factory = $this->getTesteeInstance(
            widgetConfig: $widgetConfig,
        );

        $resultWidgetConfig = $factory->create($widgetSettings);
        $resultWidgetRevolverConfig = $resultWidgetConfig->getWidgetRevolverConfig();

        self::assertInstanceOf(RootWidgetConfig::class, $resultWidgetConfig);
        self::assertSame($leadingSpacer, $resultWidgetConfig->getLeadingSpacer());
        self::assertSame($trailingSpacer, $resultWidgetConfig->getTrailingSpacer());

        self::assertSame($stylePalette, $resultWidgetRevolverConfig->getStylePalette());
        self::assertSame($charPalette, $resultWidgetRevolverConfig->getCharPalette());
        self::assertSame($revolverConfig, $resultWidgetRevolverConfig->getRevolverConfig());
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    private function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    private function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }
}
