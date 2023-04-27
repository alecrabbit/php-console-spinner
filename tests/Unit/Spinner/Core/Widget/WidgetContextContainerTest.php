<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetIntervalContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetContextContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;

final class WidgetContextContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widget = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetContextContainer::class, $widget);
    }

    public function getTesteeInstance(
        ?WeakMap $map = null,
        ?IWidgetIntervalContainer $intervalContainer = null,
    ): IWidgetContextContainer {
        return new WidgetContextContainer(
            map: $map ?? new WeakMap(),
            intervalContainer: $intervalContainer ?? $this->getWidgetIntervalContainerMock(),
        );
    }

    #[Test]
    public function canAddContexts(): void
    {
        $map = new WeakMap();

        $interval = $this->getIntervalMock();

        $intervalContainer = $this->getWidgetIntervalContainerMock();
        $intervalContainer
            ->expects(self::once())
            ->method('add')
            ->with($interval)
        ;

        $container = $this->getTesteeInstance(
            map: $map,
            intervalContainer: $intervalContainer,
        );

        $widget = $this->getWidgetMock();
        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::once())
            ->method('getWidget')
            ->willReturn($widget)
        ;
        $widget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        self::assertNull($container->getIntervalContainer()->getSmallest());

        $container->add($context);

        self::assertSame($context, $map[$context]);
    }

    #[Test]
    public function canRemoveContexts(): void
    {
        $map = new WeakMap();

        $interval = $this->getIntervalMock();

        $intervalContainer = $this->getWidgetIntervalContainerMock();
        $intervalContainer
            ->expects(self::once())
            ->method('remove')
            ->with($interval)
        ;

        $container = $this->getTesteeInstance(
            map: $map,
            intervalContainer: $intervalContainer,
        );

        $widget = $this->getWidgetMock();
        $context = $this->getWidgetContextMock();
        $context
            ->expects(self::once())
            ->method('getWidget')
            ->willReturn($widget)
        ;
        $widget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $map->offsetSet($context, $context);

        $container->remove($context);

        self::assertFalse($map->offsetExists($context));
        self::assertNull($container->getIntervalContainer()->getSmallest());
    }

    #[Test]
    public function removingNonExistingContextDoesNotThrow(): void
    {
        $map = new WeakMap();
        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context = $this->getWidgetContextMock();

        self::assertFalse($map->offsetExists($context));

        $container->remove($context);
    }

    #[Test]
    public function canGetContext(): void
    {
        $map = new WeakMap();

        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context = $this->getWidgetContextMock();

        $container->add($context);

        self::assertSame($context, $container->get($context));
    }

    #[Test]
    public function canFindContext(): void
    {
        $container = $this->getTesteeInstance();

        $context = $this->getWidgetContextMock();
        $widget = $this->getWidgetMock();
        $widget
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($context)
        ;

        $container->add($context);

        self::assertSame($context, $container->find($widget));
    }

    #[Test]
    public function canCheckContainerHasContext(): void
    {
        $container = $this->getTesteeInstance();

        $context = $this->getWidgetContextMock();

        $container->add($context);

        self::assertTrue($container->has($context));
        self::assertFalse($container->has($this->getWidgetContextMock()));
    }

    #[Test]
    public function throwsIfContextNotFound(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Context not found.';

        $test = function (): void {
            $container = $this->getTesteeInstance();
            $context = $this->getWidgetContextMock();
            self::assertSame($context, $container->get($context));
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

}
