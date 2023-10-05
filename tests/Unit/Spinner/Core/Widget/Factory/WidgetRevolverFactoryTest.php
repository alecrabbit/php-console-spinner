<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetRevolverFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverFactory::class, $widgetRevolverFactory);
    }

    public function getTesteeInstance(
        ?IWidgetRevolverBuilder $widgetRevolverBuilder = null,
        ?IStyleFrameRevolverFactory $styleRevolverFactory = null,
        ?ICharFrameRevolverFactory $charRevolverFactory = null,
        ?IPatternFactory $patternFactory = null,
    ): IWidgetRevolverFactory {
        return new WidgetRevolverFactory(
            widgetRevolverBuilder: $widgetRevolverBuilder ?? $this->getWidgetRevolverBuilderMock(),
            styleRevolverFactory: $styleRevolverFactory ?? $this->getStyleFrameRevolverFactoryMock(),
            charRevolverFactory: $charRevolverFactory ?? $this->getCharFrameRevolverFactoryMock(),
            patternFactory: $patternFactory ?? $this->getPatternFactoryMock(),
        );
    }

    private function getPatternFactoryMock(): MockObject&IPatternFactory
    {
        return $this->createMock(IPatternFactory::class);
    }

    #[Test]
    public function canCreateWidgetRevolver(): void
    {
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $widgetSettings = $this->getLegacyWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getStylePattern')
            ->willReturn($stylePattern)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getCharPattern')
            ->willReturn($charPattern)
        ;

        $styleRevolver = $this->getFrameRevolverMock();
        $charRevolver = $this->getFrameRevolverMock();

        $widgetRevolverBuilder = $this->getWidgetRevolverBuilderMock();
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('withStyleRevolver')
            ->with(self::identicalTo($styleRevolver))
            ->willReturnSelf()
        ;
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('withCharRevolver')
            ->with(self::identicalTo($charRevolver))
            ->willReturnSelf()
        ;
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('withTolerance')
            ->with(self::equalTo(new Tolerance())) // [fd86d318-9069-47e2-b60d-a68f537be4a3]
            ->willReturnSelf()
        ;
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('build')
        ;

        $styleRevolverFactory = $this->getStyleFrameRevolverFactoryMock();
        $styleRevolverFactory
            ->expects(self::once())
            ->method('createStyleRevolver')
            ->with(self::identicalTo($stylePattern))
            ->willReturn($styleRevolver)
        ;
        $charRevolverFactory = $this->getCharFrameRevolverFactoryMock();
        $charRevolverFactory
            ->expects(self::once())
            ->method('createCharRevolver')
            ->with(self::identicalTo($charPattern))
            ->willReturn($charRevolver)
        ;

        $widgetRevolverFactory = $this->getTesteeInstance(
            widgetRevolverBuilder: $widgetRevolverBuilder,
            styleRevolverFactory: $styleRevolverFactory,
            charRevolverFactory: $charRevolverFactory,
        );

        self::assertInstanceOf(WidgetRevolverFactory::class, $widgetRevolverFactory);
        $widgetRevolverFactory->legacyCreateWidgetRevolver($widgetSettings);
    }

    #[Test]
    public function canCreate(): void
    {
        $widgetRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverFactory::class, $widgetRevolverFactory);

        $config = $this->getWidgetRevolverConfigMock();

        $widgetRevolverFactory->create($config);
    }

    private function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
