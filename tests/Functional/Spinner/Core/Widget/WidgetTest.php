<?php

declare(strict_types=1);

namespace Functional\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Core\Widget\WidgetContextContainer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetTest extends TestCaseWithPrebuiltMocksAndStubs
{

    #[Test]
    public function canGetFrame(): void
    {
        $container = new WidgetContextContainer();

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
            children: $container,
        );

        $otherWidgetContext1 = $this->getWidgetContextMock();
        $otherWidget1 = $this->getWidgetMock();
        $otherWidgetContext1
            ->method('getWidget')
            ->willReturn($otherWidget1)
        ;

        $otherWidget1
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($otherWidgetContext1)
        ;

        $otherWidget1
            ->method('getFrame')
            ->willReturn(new Frame('o1', 2))
        ;
        $otherWidgetContext2 = $this->getWidgetContextMock();
        $otherWidget2 = $this->getWidgetMock();
        $otherWidgetContext2
            ->method('getWidget')
            ->willReturn($otherWidget2)
        ;
        $otherWidget2
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($otherWidgetContext2)
        ;
        $otherWidget2
            ->method('getFrame')
            ->willReturn(new Frame('o2', 2))
        ;

        $widget->add($otherWidget1);
        $widget->add($otherWidget2);

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

        self::assertSame('lsrfstso1o2', $result->sequence());
        self::assertSame(11, $result->width());
    }


    public function getTesteeInstance(
        ?IRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IWidgetContextContainer $children = null,
        ?IObserver $observer = null,
    ): IWidget {
        return new Widget(
            revolver: $revolver ?? $this->getRevolverMock(),
            leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
            trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
            children: $children ?? $this->getWidgetContextContainerMock(),
            observer: $observer,
        );
    }
}
