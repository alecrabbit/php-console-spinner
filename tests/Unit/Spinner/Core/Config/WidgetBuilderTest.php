<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\WidgetBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetBuilderTest extends TestCase
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

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function canBuildWidgetWithWidgetConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn($this->createMock(IWidgetRevolverBuilder::class));
//            ->method('get')
//            ->willReturn(new DefaultsProvider());

        $widgetBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $frame = $this->createMock(IFrame::class);
        $widgetConfig = new WidgetConfig($frame, $frame);
        $widgetComposite = $widgetBuilder->withWidgetConfig($widgetConfig)->build();

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    #[Test]
    public function throwsOnBuildWidgetWithoutWidgetConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn($this->createMock(IWidgetRevolverBuilder::class));

        $widgetBuilder = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $exceptionClass = \LogicException::class;
        $exceptionMessage = '[AlecRabbit\Spinner\Core\Config\WidgetBuilder]: Property $widgetConfig is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $widget = $widgetBuilder->build();

        self::exceptionNotThrown($exceptionClass, $exceptionMessage);
    }
}
