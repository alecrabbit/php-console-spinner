<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IInitialWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\InitialWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(InitialWidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IWidgetSettingsSolver $widgetSettingsSolver = null,
    ): IInitialWidgetConfigFactory {
        return
            new InitialWidgetConfigFactory(
                widgetSettingsSolver: $widgetSettingsSolver ?? $this->getWidgetSettingsSolverMock(),
            );
    }

    private function getWidgetSettingsSolverMock(): MockObject&IWidgetSettingsSolver
    {
        return $this->createMock(IWidgetSettingsSolver::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePalette = $this->getStylePaletteMock();
        $charPalette = $this->getCharPaletteMock();

        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($stylePalette)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn($charPalette)
        ;

        $widgetSettingsSolver = $this->getWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            widgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
        self::assertSame($leadingSpacer, $result->getLeadingSpacer());
        self::assertSame($trailingSpacer, $result->getTrailingSpacer());
        self::assertSame($stylePalette, $result->getWidgetRevolverConfig()->getStylePalette());
        self::assertSame($charPalette, $result->getWidgetRevolverConfig()->getCharPalette());
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
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

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesLeadingSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Leading spacer expected to be set.');

        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn(null)
        ;

        $widgetSettingsSolver = $this->getWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            widgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesTrailingSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Trailing spacer expected to be set.');

        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn(null)
        ;

        $widgetSettingsSolver = $this->getWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            widgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesStylePaletteSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Style palette expected to be set.');

        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn(null)
        ;

        $widgetSettingsSolver = $this->getWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            widgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesCharPaletteSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Char palette expected to be set.');

        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($this->getStylePaletteMock())
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn(null)
        ;

        $widgetSettingsSolver = $this->getWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            widgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }
}
