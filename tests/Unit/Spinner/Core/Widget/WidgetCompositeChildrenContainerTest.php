<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;

final class WidgetCompositeChildrenContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeChildrenContainer::class, $container);
    }

    public function getTesteeInstance(
        null|(ArrayAccess&Countable&IteratorAggregate) $map = null,
        ?IObserver $observer = null,
    ): IWidgetCompositeChildrenContainer {
        return new WidgetCompositeChildrenContainer(
            map: $map ?? $this->getWeakMapMock(),
            observer: $observer,
        );
    }

    #[Test]
    public function observerGetsNotifiedAndCanGetInterval(): void
    {
        $observer = $this->getObserverMock();

        $container = $this->getTesteeInstance(
            map: new WeakMap(),
            observer: $observer,
        );

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($container)
        ;

        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->willReturnSelf()
        ;

        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $container->add($context);
        self::assertSame($interval, $container->getInterval());
    }

    #[Test]
    public function isInstanceOfObserver(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(IObserver::class, $container);
    }

    #[Test]
    public function isInstanceOfSubject(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(ISubject::class, $container);
    }

    #[Test]
    public function canAddWidgetContextToContainer(): void
    {
        $map = $this->getWeakMapMock();

        $context = $this->getWidgetContextMock();

        $map
            ->expects(self::once())
            ->method('offsetSet')
            ->with($context)
        ;

        $container = $this->getTesteeInstance(
            map: $map,
        );
        $context
            ->expects(self::once())
            ->method('attach')
            ->with($container)
        ;
        $map
            ->expects(self::once())
            ->method('offsetExists')
            ->with($context)
            ->willReturn(false)
        ;
        $map
            ->expects(self::once())
            ->method('count')
            ->willReturn(1)
        ;
        $context = $container->add($context);

        self::assertSame($context, $context);
        self::assertFalse($container->isEmpty());
    }

    #[Test]
    public function containerIsAttachedAsObserverToAddedWidgetContext(): void
    {
        $context = $this->getWidgetContextMock();

        $container = $this->getTesteeInstance();

        $context
            ->expects(self::once())
            ->method('attach')
            ->with($container)
        ;

        $container->add($context);
    }

    #[Test]
    public function containerIsDetachedAsObserverFromRemovedWidgetContext(): void
    {
        $map = new WeakMap();

        $interval = $this->getIntervalMock();

        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::exactly(2))
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $container = $this->getTesteeInstance(
            map: $map,
        );

        $container->add($context);

        $context
            ->expects(self::once())
            ->method('detach')
            ->with($container)
        ;

        $container->remove($context);
    }

    #[Test]
    public function createdEmptyByDefault(): void
    {
        $container = $this->getTesteeInstance();

        self::assertTrue($container->isEmpty());
    }

    #[Test]
    public function canRemoveWidgetContext(): void
    {
        $context = $this->getWidgetContextMock();

        $container = $this->getTesteeInstance();

        $container->add($context);

        $container->remove($context);

        self::assertFalse($container->has($context));
        self::assertTrue($container->isEmpty());
    }

    #[Test]
    public function canReturnIterator(): void
    {
        $map = new WeakMap();

        $container = $this->getTesteeInstance(
            map: $map,
        );

        /** @noinspection PhpUnhandledExceptionInspection */
        $iterator = $container->getIterator();

        self::assertSame($map, $iterator);
    }

    #[Test]
    public function observerUpdateInvokedOnIntervalChange(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with(null)
            ->willReturnSelf()
        ;

        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $observer = $this->getObserverMock();

        $container = $this->getTesteeInstance(
            observer: $observer,
        );

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($container)
        ;

        $container->add($context);
    }

    #[Test]
    public function canBeUpdatedByAddedContext(): void
    {
        $map = $this->getWeakMapMock();
        $observer = $this->getObserverMock();
        $interval = null;
        $newInterval = $this->getIntervalMock();
        $context = $this->getWidgetContextMock();

        $map
            ->expects(self::once())
            ->method('offsetExists')
            ->with($context)
            ->willReturn(true)
        ;
        $map
            ->expects(self::once())
            ->method('offsetGet')
            ->with($context)
            ->willReturn($interval)
        ;
        $map
            ->expects(self::once())
            ->method('offsetSet')
            ->with($context, $newInterval)
        ;

        $context
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($newInterval)
        ;

        $container = $this->getTesteeInstance(
            map: $map,
            observer: $observer,
        );

        $newInterval
            ->expects(self::once())
            ->method('smallest')
            ->with(null)
            ->willReturnSelf()
        ;

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($container)
        ;

        $container->update($context);
    }

    #[Test]
    public function returnsNullOnGetIntervalWhenEmpty(): void
    {
        $container = $this->getTesteeInstance();

        self::assertNull($container->getInterval());
    }

    #[Test]
    public function intervalContainerMethodAddInvokedOnContextAdd(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with(null)
            ->willReturnSelf()
        ;

        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $observer = $this->getObserverMock();

        $container = $this->getTesteeInstance(
            observer: $observer,
        );

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($container)
        ;

        $container->add($context);
    }

    #[Test]
    public function throwsIfUpdateInvokedForSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $container = $this->getTesteeInstance();

            $container->update($container);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
