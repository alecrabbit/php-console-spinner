<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetRevolverFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetRevolverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverFactory::class, $widgetRevolverFactory);
    }

    public function getTesteeInstance(
        ?IWidgetRevolverBuilder $widgetRevolverBuilder = null,
        ?IStyleFrameRevolverFactory $styleRevolverFactory = null,
        ?ICharFrameRevolverFactory $charRevolverFactory = null,
    ): IWidgetRevolverFactory {
        return new WidgetRevolverFactory(
            widgetRevolverBuilder: $widgetRevolverBuilder ?? $this->getWidgetRevolverBuilderMock(),
            styleRevolverFactory: $styleRevolverFactory ?? $this->getStyleFrameRevolverFactoryMock(),
            charRevolverFactory: $charRevolverFactory ?? $this->getCharFrameRevolverFactoryMock(),
        );
    }

    #[Test]
    public function canCreateWidgetRevolver(): void
    {
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getPatternMock();

        $widgetSettings = $this->getWidgetSettingsMock();
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
        $widgetRevolverFactory->createWidgetRevolver($widgetSettings);
    }
}
