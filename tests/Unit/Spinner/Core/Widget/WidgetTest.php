<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
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

    #[Test]
    public function canBeUpdated(): void
    {
        $interval = $this->getIntervalMock();
        $revolver = $this->getRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval);

        $widget = $this->getTesteeInstance(
            revolver: $revolver
        );

        self::assertSame($interval, $widget->getInterval());

        $otherInterval = $this->getIntervalMock();
        $otherWidget = $this->getWidgetMock();
        $otherWidget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($otherInterval);
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with($otherInterval)
            ->willReturn($otherInterval);

        $widget->update($otherWidget);

        self::assertSame($otherInterval, $widget->getInterval());
    }

    #[Test]
    public function canAttachObserver(): void
    {
        $widget = $this->getTesteeInstance();

        $observer = $this->getObserverMock();

        self::assertNull(self::getPropertyValue('observer', $widget));

        $widget->attach($observer);

        self::assertSame($observer, self::getPropertyValue('observer', $widget));
    }

    #[Test]
    public function canDetachObserver(): void
    {
        $observer = $this->getObserverMock();

        $widget = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue('observer', $widget));

        $widget->detach($observer);

        self::assertNull(self::getPropertyValue('observer', $widget));
    }

    #[Test]
    public function canNotifyObserverOnOtherWidgetAdd(): void
    {
        $observer = $this->getObserverMock();
        $intervalContainer = $this->getWidgetIntervalContainerMock();
        $children = $this->getWidgetContextContainerMock();


        $widget = $this->getTesteeInstance(
            children: $children,
            observer: $observer,
        );

        $otherWidgetContext = $this->getWidgetContextMock();
        $otherWidget = $this->getWidgetMock();

        $otherWidget
            ->expects(self::once())
            ->method('attach')
            ->with($widget)
        ;

        $otherWidget
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($otherWidgetContext)
        ;

        $children
            ->expects(self::once())
            ->method('add')
            ->with($otherWidgetContext)
        ;

        $children
            ->expects(self::once())
            ->method('getIntervalContainer')
            ->willReturn($intervalContainer)
        ;

        $intervalContainer
            ->expects(self::once())
            ->method('getSmallest')
            ->willReturn($this->getIntervalMock())
        ;

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($widget)
        ;

        $widget->add($otherWidget);
    }

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

    #[Test]
    public function canReplaceContext(): void
    {
        $widget = $this->getTesteeInstance();

        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::once())
            ->method('getWidget')
            ->willReturn($widget)
        ;

        $widget->replaceContext($context);

        self::assertSame($context, $widget->getContext());
    }

    #[Test]
    public function canGetContext(): void
    {
        $widget = $this->getTesteeInstance();

        $context = self::getPropertyValue('context', $widget);

        self::assertSame($context, $widget->getContext());
    }


    #[Test]
    public function canNotifyObserverOnOtherWidgetRemove(): void
    {
        $observer = $this->getObserverMock();

        $intervalContainer = $this->getWidgetIntervalContainerMock();

        $children = $this->getWidgetContextContainerMock();

        $widget = $this->getTesteeInstance(
            children: $children,
            observer: $observer,
        );

        $otherWidgetContext = $this->getWidgetContextMock();
        $otherWidget = $this->getWidgetMock();

        $otherWidget
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($otherWidgetContext)
        ;

        $children
            ->expects(self::once())
            ->method('has')
            ->with($otherWidgetContext)
            ->willReturn(true)
        ;

        $children
            ->expects(self::once())
            ->method('remove')
            ->with($otherWidgetContext)
        ;

        $otherWidget
            ->expects(self::once())
            ->method('detach')
            ->with($widget)
        ;

        $children
            ->expects(self::once())
            ->method('getIntervalContainer')
            ->willReturn($intervalContainer)
        ;

        $intervalContainer
            ->expects(self::once())
            ->method('getSmallest')
            ->willReturn($this->getIntervalMock())
        ;

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($widget)
        ;

        $widget->remove($otherWidget);
    }

    #[Test]
    public function removingNonExistentWidgetDoesNothing(): void
    {
        $children = $this->getWidgetContextContainerMock();
        $composite = $this->getTesteeInstance(
            children: $children,
        );

        $nonExistentContext = $this->getWidgetContextMock();
        $nonExistent = $this->getWidgetMock();
        $nonExistent
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($nonExistentContext)
        ;
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
        $nonExistent
            ->expects(self::never())
            ->method('detach')
        ;
        $children
            ->expects(self::never())
            ->method('getIntervalContainer')
        ;
        $composite->remove($nonExistent);
    }

    #[Test]
    public function throwsIfObserverIsSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();
            $widget->attach($widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Observer is already attached.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();
            $observer = $this->getObserverMock();
            $widget->attach($observer);
            $widget->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfAddedWidgetIsSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();
            $widget->add($widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfContextIsNotRelatedToWidget(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Context is not related to this widget.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();

            $context = $this->getWidgetContextMock();
            $context
                ->expects(self::once())
                ->method('getWidget')
                ->willReturn($this->getWidgetMock())
            ;

            $widget->replaceContext($context);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfUpdateInvokedForSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();

            $widget->update($widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }
}
