<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetComposite;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetCompositeTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetComposite = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetComposite::class, $widgetComposite);
    }

    public function getTesteeInstance(
        ?IWidgetRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IIntervalComparator $intervalComparator = null,
        ?IWidgetCompositeChildrenContainer $children = null,
        ?IObserver $observer = null,
    ): IWidgetComposite {
        return new WidgetComposite(
            revolver: $revolver ?? $this->getWidgetRevolverMock(),
            leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
            trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
            intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
            children: $children ?? $this->getWidgetCompositeChildrenContainerMock(),
            observer: $observer,
        );
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    protected function getWidgetCompositeChildrenContainerMock(): MockObject&IWidgetCompositeChildrenContainer
    {
        return $this->createMock(IWidgetCompositeChildrenContainer::class);
    }

    #[Test]
    public function isAttachedAsObserverToChildrenContainer(): void
    {
        $children = $this->getWidgetCompositeChildrenContainerMock();
        $children
            ->expects(self::once())
            ->method('attach')
            ->with(self::isInstanceOf(IWidgetComposite::class))
        ;

        $widgetComposite = $this->getTesteeInstance(
            children: $children,
        );

        self::assertInstanceOf(WidgetComposite::class, $widgetComposite);
    }

    #[Test]
    public function canBeUpdated(): void
    {
        $revolverInterval = $this->getIntervalMock();

        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($revolverInterval)
        ;

        $children = $this->getWidgetCompositeChildrenContainerMock();
        $initialInterval = $this->getIntervalMock();

        $children
            ->expects(self::exactly(2))
            ->method('getInterval')
            ->willReturn($initialInterval)
        ;

        $intervalComparator = $this->getIntervalComparatorMock();
        $intervalComparator
            ->expects(self::exactly(2))
            ->method('smallest')
            ->willReturn($initialInterval)
        ;

        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
            intervalComparator: $intervalComparator,
            children: $children,
        );

        self::assertSame($initialInterval, $widgetComposite->getInterval());

        $children
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($initialInterval)
        ;

        $widgetComposite->update($children);

        self::assertSame($initialInterval, $widgetComposite->getInterval());
    }

//

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetFrameIfHasRevolverOnly(): void
    {
        $revolverFrame = $this->getFrameMock();
        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getFrame')
            ->willReturn($revolverFrame)
        ;

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
        );

        $revolverFrame
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('rfs')
        ;
        $revolverFrame
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(3)
        ;

        $leadingSpacer
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('ls')
        ;
        $leadingSpacer
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(2)
        ;

        $trailingSpacer
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('ts')
        ;
        $trailingSpacer
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(2)
        ;

        $result = $widgetComposite->getFrame();

        self::assertSame('lsrfsts', $result->getSequence());
        self::assertSame(7, $result->getWidth());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $intervalComparator = $this->getIntervalComparatorMock();
        $interval = $this->getIntervalMock();
        $intervalComparator
            ->method('smallest')
            ->with($interval, null)
            ->willReturn($interval)
        ;
        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
            intervalComparator: $intervalComparator,
        );
        self::assertSame($interval, $widgetComposite->getInterval());
    }

    #[Test]
    public function shouldNotifyObserverOnIntervalChange(): void
    {
        $interval = $this->getIntervalMock();
        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $children = $this->getWidgetCompositeChildrenContainerMock();
        $otherInterval = $this->getIntervalMock();
        $children
            ->expects(self::exactly(2))
            ->method('getInterval')
            ->willReturn($otherInterval)
        ;

        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
            children: $children,
        );

        $children
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($otherInterval)
        ;


        $observer = $this->getObserverMock();
        $widgetComposite->attach($observer);

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($widgetComposite)
        ;

        $widgetComposite->update($children);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function removingNonExistentWidgetDoesNothing(): void
    {
        $children = $this->getWidgetCompositeChildrenContainerMock();
        $composite = $this->getTesteeInstance(
            children: $children,
        );

        $nonExistentContext = $this->getWidgetContextMock();

        $children
            ->expects(self::once())
            ->method('has')
            ->with($nonExistentContext)
            ->willReturn(false)
        ;
        $children
            ->expects(self::never())
            ->method('remove')
        ;
        $nonExistentContext
            ->expects(self::never())
            ->method('detach')
        ;

        $composite->remove($nonExistentContext);
    }

    protected function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }

    #[Test]
    public function contextCanBeAdded(): void
    {
        $context = $this->getWidgetContextMock();
        $children = $this->getWidgetCompositeChildrenContainerMock();
        $children
            ->expects(self::once())
            ->method('add')
            ->with($context)
            ->willReturn($context)
        ;

        $widgetComposite = $this->getTesteeInstance(
            children: $children,
        );

        self::assertSame($context, $widgetComposite->add($context));
    }

    #[Test]
    public function contextCanBeRemoved(): void
    {
        $context = $this->getWidgetContextMock();
        $children = $this->getWidgetCompositeChildrenContainerMock();

        $widgetComposite = $this->getTesteeInstance(
            children: $children,
        );

        $children
            ->expects(self::once())
            ->method('has')
            ->with($context)
            ->willReturn(true)
        ;
        $children
            ->expects(self::once())
            ->method('remove')
            ->with($context)
        ;

        $widgetComposite->remove($context);
    }

    #[Test]
    public function throwsIfObserverIsSelf(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widgetComposite = $this->getTesteeInstance();
            $widgetComposite->attach($widgetComposite);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = ObserverCanNotBeOverwritten::class;
        $exceptionMessage = 'Observer is already attached.';

        $test = function (): void {
            $widgetComposite = $this->getTesteeInstance();
            $observer = $this->getObserverMock();
            $widgetComposite->attach($observer);
            $widgetComposite->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfUpdateInvokedForSelf(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widgetComposite = $this->getTesteeInstance();

            $widgetComposite->update($widgetComposite);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
