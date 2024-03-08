<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConsoleCursorBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $consoleCursorBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConsoleCursorBuilder::class, $consoleCursorBuilder);
    }

    public function getTesteeInstance(): IConsoleCursorBuilder
    {
        return new ConsoleCursorBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $buffer = $this->getBufferMock();
        $consoleCursorBuilder = $this->getTesteeInstance();
        $cursorMode = CursorMode::VISIBLE;
        $consoleCursor =
            $consoleCursorBuilder
                ->withBuffer($buffer)
                ->withCursorMode($cursorMode)
                ->build()
        ;
        self::assertInstanceOf(ConsoleCursor::class, $consoleCursor);
        self::assertSame($buffer, self::getPropertyValue($consoleCursor, 'buffer'));
        self::assertSame($cursorMode, self::getPropertyValue($consoleCursor, 'cursorVisibilityMode'));
    }

    private function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
    }

    #[Test]
    public function throwsIfBufferIsNotSet(): void
    {
        $consoleCursorBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Buffer is not set.');

        $consoleCursorBuilder
            ->withCursorMode(CursorMode::VISIBLE)
            ->build()
        ;
    }

    #[Test]
    public function throwsIfCursorModeIsNotSet(): void
    {
        $consoleCursorBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('CursorMode is not set.');

        $consoleCursorBuilder
            ->withBuffer($this->getBufferMock())
            ->build()
        ;
    }
}
