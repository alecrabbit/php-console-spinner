<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetComposite;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetComposite = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetComposite::class, $widgetComposite);
    }

    public function getTesteeInstance(
        ?IRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IWidgetCompositeChildrenContainer $children = null,
        ?IObserver $observer = null,
    ): IWidgetComposite {
        return new WidgetComposite(
            revolver: $revolver ?? $this->getRevolverMock(),
            leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
            trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
            children: $children ?? $this->getWidgetCompositeChildrenContainerMock(),
            observer: $observer,
        );
    }

    #[Test]
    public function isAttachedAsObserverToChildrenContainer(): void
    {
        $children = $this->getWidgetCompositeChildrenContainerMock();
        $children
            ->expects(self::once())
            ->method('attach')
            ->with($this->isInstanceOf(IWidgetComposite::class))
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

        $revolver = $this->getRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($revolverInterval)
        ;
        $children = $this->getWidgetCompositeChildrenContainerMock();
        $initialInterval = $this->getIntervalMock();
        $revolverInterval
            ->expects(self::once())
            ->method('smallest')
            ->with($initialInterval)
            ->willReturn($initialInterval)
        ;
        $children
            ->expects(self::exactly(2))
            ->method('getInterval')
            ->willReturn($initialInterval)
        ;

        $initialInterval
            ->expects(self::once())
            ->method('smallest')
            ->with($initialInterval)
            ->willReturnSelf()
        ;

        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
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
        $widgetComposite = $this->getTesteeInstance(
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

        $result = $widgetComposite->getFrame();

        self::assertSame('lsrfsts', $result->sequence());
        self::assertSame(7, $result->width());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with(null)
            ->willReturn($interval)
        ;
        $revolver = $this->getRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
        );
        self::assertSame($interval, $widgetComposite->getInterval());
    }

//
    #[Test]
    public function shouldNotifyObserverOnIntervalChange(): void
    {
        $interval = $this->getIntervalMock();
        $revolver = $this->getRevolverMock();
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
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with($otherInterval)
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
        $exceptionClass = InvalidArgumentException::class;
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
        $exceptionClass = InvalidArgumentException::class;
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
        $exceptionClass = InvalidArgumentException::class;
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
