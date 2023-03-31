<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\WidgetBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(WidgetBuilder::class, $builder);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IWidgetBuilder {
        return
            new WidgetBuilder(
                container: $container ?? $this->getContainerMock(),
            );
    }

    #[Test]
    public function canBuildWidgetWithWidgetConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn($this->createMock(IWidgetRevolverBuilder::class))
        ;

        $widgetBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $widgetConfig = $this->getWidgetConfigMock();
        $widgetComposite = $widgetBuilder->withWidgetConfig($widgetConfig)->build();

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    #[Test]
    public function canBuildWidgetWithWidgetRevolver(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn($this->createMock(IWidgetRevolverBuilder::class))
        ;

        $widgetBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $widgetConfig = $this->getWidgetConfigMock();
        $revolver = $this->createMock(IRevolver::class);
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
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn($this->createMock(IWidgetRevolverBuilder::class))
        ;

        $widgetBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $frame = $this->createMock(IFrame::class);

        $widgetComposite =
            $widgetBuilder
                ->withLeadingSpacer($frame)
                ->withTrailingSpacer($frame)
                ->build()
        ;

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    #[Test]
    public function throwsOnBuildWidgetWithoutWidgetConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn($this->createMock(IWidgetRevolverBuilder::class))
        ;

        $widgetBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = '[AlecRabbit\Spinner\Core\Config\WidgetBuilder]: Property $widgetConfig is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $widget = $widgetBuilder->build();

        self::assertInstanceOf(Widget::class, $widget);
        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
