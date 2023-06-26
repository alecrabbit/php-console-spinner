<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetComposite;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeTest extends TestCaseWithPrebuiltMocksAndStubs
{

//    #[Test]
//    public function dummy(): void
//    {
//        // FIXME (2023-06-22 13:32) [Alec Rabbit]: remove method
//        self::assertTrue(true); // dummy test
//    }

    #[Test]
    public function canGetFrame(): void
    {
        $children = new WidgetCompositeChildrenContainer();

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
            children: $children,
        );

        $otherWidgetContext1 = $this->getWidgetContextMock();
        $otherWidget1 = $this->getWidgetMock();
        $otherWidgetContext1
            ->method('getWidget')
            ->willReturn($otherWidget1)
        ;

        $otherWidget1
            ->method('getFrame')
            ->willReturn(new CharFrame('o1', 2))
        ;
        $otherWidgetContext2 = $this->getWidgetContextMock();
        $otherWidget2 = $this->getWidgetMock();
        $otherWidgetContext2
            ->method('getWidget')
            ->willReturn($otherWidget2)
        ;

        $otherWidget2
            ->method('getFrame')
            ->willReturn(new CharFrame('o2', 2))
        ;

        $widget->add($otherWidgetContext1);
        $widget->add($otherWidgetContext2);

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
        ?IWidgetCompositeChildrenContainer $children = null,
        ?IObserver $observer = null,
    ): IWidgetComposite {
        return
            new WidgetComposite(
                revolver: $revolver ?? $this->getRevolverMock(),
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                children: $children ?? $this->getWidgetCompositeChildrenContainerMock(),
                observer: $observer,
            );
    }
}
