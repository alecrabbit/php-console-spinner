<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\ISignalHandlersContainer;
use AlecRabbit\Spinner\Core\SignalHandlersContainer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SignalHandlersContainerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersContainer::class, $container);
    }

    private function getTesteeInstance(
        ?\Traversable $handlers = null,
    ): ISignalHandlersContainer
    {
        return new SignalHandlersContainer(
            signalHandlers: $handlers ?? $this->getSignalHandlersMock(),
        );
    }

    private function getSignalHandlersMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    #[Test]
    public function canGetSignalHandlers(): void
    {
        $handlers = $this->getSignalHandlersMock();

        $container = $this->getTesteeInstance(
            handlers: $handlers,
        );

        self::assertSame($handlers, $container->getSignalHandlers());
    }
}
