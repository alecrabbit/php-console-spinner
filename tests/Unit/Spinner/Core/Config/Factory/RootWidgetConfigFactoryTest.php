<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IInitialRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\InitialRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RootWidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(InitialRootWidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IRootWidgetSettingsSolver $rootWidgetSettingsSolver = null,
        ?IWidgetSettingsSolver $widgetSettingsSolver = null,
    ): IInitialRootWidgetConfigFactory {
        return
            new InitialRootWidgetConfigFactory(
                rootWidgetSettingsSolver: $rootWidgetSettingsSolver ?? $this->getRootWidgetSettingsSolverMock(),
                widgetSettingsSolver: $widgetSettingsSolver ?? $this->getWidgetSettingsSolverMock(),
            );
    }

    private function getRootWidgetSettingsSolverMock(): MockObject&IRootWidgetSettingsSolver
    {
        return $this->createMock(IRootWidgetSettingsSolver::class);
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

        $rootWidgetSettings = $this->getRootWidgetSettingsMock();
        $rootWidgetSettings
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($stylePalette)
        ;
        $rootWidgetSettings
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn($charPalette)
        ;

        $rootWidgetSettingsSolver = $this->getRootWidgetSettingsSolverMock();
        $rootWidgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($rootWidgetSettings)
        ;

        $widgetSettingsSolver = $this->getWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            rootWidgetSettingsSolver: $rootWidgetSettingsSolver,
            widgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(RootWidgetConfig::class, $result);
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

    private function getRootWidgetSettingsMock(): MockObject&IRootWidgetSettings
    {
        return $this->createMock(IRootWidgetSettings::class);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesLeadingSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Leading spacer expected to be set.');

        $widgetSettings = $this->getRootWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn(null)
        ;

        $widgetSettingsSolver = $this->getRootWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            rootWidgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesTrailingSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Trailing spacer expected to be set.');

        $widgetSettings = $this->getRootWidgetSettingsMock();
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

        $widgetSettingsSolver = $this->getRootWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            rootWidgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesStylePaletteSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Style palette expected to be set.');

        $widgetSettings = $this->getRootWidgetSettingsMock();
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

        $widgetSettingsSolver = $this->getRootWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            rootWidgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }

    #[Test]
    public function throwsIfSolvedWidgetSettingsMissesCharPaletteSpacer(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Char palette expected to be set.');

        $widgetSettings = $this->getRootWidgetSettingsMock();
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

        $widgetSettingsSolver = $this->getRootWidgetSettingsSolverMock();
        $widgetSettingsSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($widgetSettings)
        ;

        $factory = $this->getTesteeInstance(
            rootWidgetSettingsSolver: $widgetSettingsSolver,
        );

        $result = $factory->create();

        self::assertInstanceOf(WidgetConfig::class, $result);
    }
}
