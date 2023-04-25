<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
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
    ): IWidgetContextContainer {
        return new WidgetContextContainer(
            map: $map ?? new WeakMap(),
        );
    }

    #[Test]
    public function canAddIObserverContexts(): void
    {
        $map = new WeakMap();

        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context = $this->getWidgetContextMock();

        $container->add($context);

        self::assertSame($context, $map[$context]);
    }

    #[Test]
    public function canRemoveContexts(): void
    {
        $map = new WeakMap();

        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context = $this->getWidgetContextMock();

        $container->add($context);

        self::assertSame($context, $map[$context]);

        $container->remove($context);

        self::assertFalse($map->offsetExists($context));
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
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }
}
