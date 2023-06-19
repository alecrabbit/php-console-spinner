<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetComposite;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widget = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetComposite::class, $widget);
    }

    public function getTesteeInstance(
        ?IRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IWidgetContextContainer $children = null,
        ?IWidgetContext $context = null,
    ): IWidgetComposite {
        return new WidgetComposite(
            revolver: $revolver ?? $this->getRevolverMock(),
            leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
            trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
            children: $children ?? $this->getWidgetContextContainerMock(),
            context: $context,
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
            ->willReturn($interval)
        ;

        $widget = $this->getTesteeInstance(
            revolver: $revolver
        );

        self::assertSame($interval, $widget->getInterval());

        $otherInterval = $this->getIntervalMock();
        $otherWidget = $this->getWidgetCompositeMock();
        $otherWidget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($otherInterval)
        ;
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with($otherInterval)
            ->willReturn($otherInterval)
        ;

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

    #[Test]
    public function canDetachObserver(): void
    {
        $context = $this->getWidgetContextMock();

        $widget = $this->getTesteeInstance(
            context: $context
        );

        self::assertSame($context, self::getPropertyValue('observer', $widget));

        $widget->detach($context);

        self::assertNull(self::getPropertyValue('observer', $widget));
    }

    #[Test]
    public function canNotifyObserverOnOtherWidgetAdd(): void
    {
        $context = $this->getWidgetContextMock();
//        $intervalContainer = $this->getWidgetIntervalContainerMock();
        $children = $this->getWidgetContextContainerMock();


        $widget = $this->getTesteeInstance(
            children: $children,
            context: $context,
        );

        $otherWidgetContext = $this->getWidgetContextMock();
        $otherWidget = $this->getWidgetCompositeMock();

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
            ->method('getInterval')
            ->willReturn($this->getIntervalMock())
        ;

        $context
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
        $context = $this->getWidgetContextMock();

//        $intervalContainer = $this->getWidgetIntervalContainerMock();

        $children = $this->getWidgetContextContainerMock();

        $widget = $this->getTesteeInstance(
            children: $children,
            context: $context,
        );

        $otherWidgetContext = $this->getWidgetContextMock();
        $otherWidget = $this->getWidgetCompositeMock();

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
            ->method('getInterval')
            ->willReturn($this->getIntervalMock())
        ;

        $context
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
        $nonExistent = $this->getWidgetCompositeMock();
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
            ->method('getInterval')
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
            $widget = $this->getTesteeInstance();
            $observer = $this->getObserverMock();
            $widget->attach($observer);
            $widget->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
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
            exception: $exceptionClass,
            message: $exceptionMessage,
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
                ->willReturn($this->getWidgetCompositeMock())
            ;

            $widget->replaceContext($context);
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
            $widget = $this->getTesteeInstance();

            $widget->update($widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}