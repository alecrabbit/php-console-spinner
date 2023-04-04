<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class WidgetBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $builder);
    }

    public function getTesteeInstance(
        ?IWidgetRevolverBuilder $widgetRevolverBuilder = null,
    ): IWidgetBuilder {
        return
            new WidgetBuilder(
                widgetRevolverBuilder: $widgetRevolverBuilder ?? $this->getWidgetRevolverBuilderMock(),
            );
    }

    #[Test]
    public function canBuildWidgetWithWidgetConfig(): void
    {
        $container = $this->getContainerMock();
        $container
            ->method('get')
            ->willReturn(
                $this->getWidgetRevolverBuilderMock(),
            )
        ;

        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $widgetConfig = $this->getWidgetConfigMock();
        $widgetComposite = $widgetBuilder->withWidgetConfig($widgetConfig)->build();

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    #[Test]
    public function canBuildWidgetWithWidgetRevolver(): void
    {
        $container = $this->getContainerMock();
        $container
            ->method('get')
            ->willReturn($this->getWidgetRevolverBuilderMock())
        ;

        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $widgetConfig = $this->getWidgetConfigMock();
        $revolver = $this->getRevolverMock();
        $widgetComposite =
            $widgetBuilder
                ->withWidgetRevolver($revolver)
                ->withWidgetConfig($widgetConfig)
                ->build()
        ;

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    #[Test]
    public function canBuildWidgetWithSpacers(): void
    {
        $container = $this->getContainerMock();

        $container
            ->method('get')
            ->willReturn(
                $this->getWidgetRevolverBuilderMock(),
            )
        ;

        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $widgetComposite =
            $widgetBuilder
                ->withWidgetConfig($this->getWidgetConfigMock())
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->build()
        ;

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    #[Test]
    public function throwsOnBuildWidgetWithoutWidgetConfig(): void
    {
        $container = $this->getContainerMock();
        $container
            ->method('get')
            ->willReturn(
                $this->getWidgetRevolverBuilderMock(),
            )
        ;

        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = '[AlecRabbit\Spinner\Core\Widget\WidgetBuilder]: Property $widgetConfig is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $widget = $widgetBuilder->build();

        self::assertInstanceOf(Widget::class, $widget);
        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

}
