<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widget = $this->getTesteeInstance();

        self::assertInstanceOf(Widget::class, $widget);
    }

    public function getTesteeInstance(
        ?IRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IObserver $observer = null,
    ): IWidget {
        return
            new Widget(
                revolver: $revolver ?? $this->getRevolverMock(),
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                observer: $observer ?? $this->getObserverMock(),
            );
    }

    #[Test]
    public function canGetContext(): void
    {
        $context = $this->getWidgetContextMock();

        $widget = $this->getTesteeInstance(
            observer: $context,
        );

        $this->expectsException(\RuntimeException::class);
        $this->expectExceptionMessage('Not implemented');

        self::assertSame($context, $widget->getContext());

        self::fail('Exception was not thrown.');
    }

//    #[Test]
//    public function notifiesContextOnCreation(): void
//    {
//        $context = $this->getWidgetContextMock();
//
//        $context
//            ->expects(self::once())
//            ->method('update')
//        ;
//
//        $widget = $this->getTesteeInstance(
//            observer: $context,
//        );
//
//        self::assertInstanceOf(Widget::class, $widget);
//    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $revolver = $this->getRevolverMock();

        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $widget = $this->getTesteeInstance(
            revolver: $revolver,
        );

        self::assertSame($interval, $widget->getInterval());
    }
//    #[Test]
//    public function canBeEnvelopedWithAnotherContext():void
//    {
//        $widget = $this->getTesteeInstance();
//
//        $context = $this->getWidgetContextMock();
//        $context
//            ->expects(self::once())
//            ->method('update')
//            ->with($widget)
//        ;
//
//        $widget->envelopWithContext($context);
//    }


    #[Test]
    public function canGetFrameIfHasRevolverOnly(): void
    {
        $revolverFrame = $this->getFrameMock();
        $revolver = $this->getRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getFrame')
            ->willReturn($revolverFrame)
        ;

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $widget = $this->getTesteeInstance(
            revolver: $revolver,
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
        );

        $revolverFrame
            ->expects(self::once())
            ->method('sequence')
            ->willReturn('rfs')
        ;
        $revolverFrame
            ->expects(self::once())
            ->method('width')
            ->willReturn(3)
        ;

        $leadingSpacer
            ->expects(self::once())
            ->method('sequence')
            ->willReturn('ls')
        ;
        $leadingSpacer
            ->expects(self::once())
            ->method('width')
            ->willReturn(2)
        ;

        $trailingSpacer
            ->expects(self::once())
            ->method('sequence')
            ->willReturn('ts')
        ;
        $trailingSpacer
            ->expects(self::once())
            ->method('width')
            ->willReturn(2)
        ;

        $result = $widget->getFrame();

        self::assertSame('lsrfsts', $result->sequence());
        self::assertSame(7, $result->width());
    }
}
