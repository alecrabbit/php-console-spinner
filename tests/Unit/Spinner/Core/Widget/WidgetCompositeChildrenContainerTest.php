<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
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
        ?WeakMap $map = null,
        ?IObserver $observer = null,
    ): IWidgetCompositeChildrenContainer {
        return new WidgetCompositeChildrenContainer(
            map: $map ?? new WeakMap(),
            observer: $observer,
        );
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
        $context = $this->getWidgetContextMock();

        $container = $this->getTesteeInstance();

        $context = $container->add($context);

        self::assertSame($context, $context);
        self::assertTrue($container->has($context));
    }

    #[Test]
    public function canRemoveWidgetContext(): void
    {
        $context = $this->getWidgetContextMock();

        $container = $this->getTesteeInstance();

        $container->add($context);

        $container->remove($context);

        self::assertFalse($container->has($context));
    }
    #[Test]
    public function canReturnIterator(): void
    {
        $map = new WeakMap();

        $container = $this->getTesteeInstance(
            map: $map,
        );

        $iterator = $container->getIterator();

        self::assertSame($map, $iterator);
    }

//    #[Test]
//    public function updateCanBeInvokedByWidgetInContainer(): void
//    {
//        $container = $this->getTesteeInstance();
//
//        $container->update($this->getWidgetMock());
//    }

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

    #[Test]
    public function throwsOnGetIntervalWhenEmpty(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Interval is not set.';

        $test = function (): void {
            $container = $this->getTesteeInstance();

            $container->getInterval();
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
