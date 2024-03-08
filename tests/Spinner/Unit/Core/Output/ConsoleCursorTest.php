<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Output;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConsoleCursorTest extends TestCase
{
    #[Test]
    public function isCreatedWithGivenOption(): void
    {
        $cursorMode = CursorMode::VISIBLE;

        $cursor = $this->getTesteeInstance(
            cursorMode: $cursorMode
        );

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue($cursor, 'cursorVisibilityMode'));
    }

    public function getTesteeInstance(
        ?IBuffer $buffer = null,
        CursorMode $cursorMode = CursorMode::HIDDEN,
    ): IConsoleCursor {
        return
            new ConsoleCursor(
                buffer: $buffer ?? $this->getBufferMock(),
                cursorVisibilityMode: $cursorMode,
            );
    }

    protected function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
    }

    #[Test]
    public function writesToOutputWhenHideCalledIfHidden(): void
    {
        $cursorMode = CursorMode::HIDDEN;

        $buffer = $this->getBufferMock();

        $hideSequence = "\x1b[?25l";
        $buffer
            ->expects(self::once())
            ->method('append')
            ->with($hideSequence)
            ->willReturnSelf()
        ;

        $cursor = $this->getTesteeInstance(buffer: $buffer, cursorMode: $cursorMode);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue($cursor, 'cursorVisibilityMode'));

        $cursor->hide();
    }

    #[Test]
    public function doesNotWriteToOutputWhenHideOrShowCalledIfEnabled(): void
    {
        $cursorMode = CursorMode::VISIBLE;

        $buffer = $this->getBufferMock();
        $buffer
            ->expects(self::never())
            ->method('append')
        ;

        $cursor = $this->getTesteeInstance(buffer: $buffer, cursorMode: $cursorMode);

        self::assertSame($cursorMode, self::getPropertyValue($cursor, 'cursorVisibilityMode'));

        $cursor->hide();
        $cursor->show();
    }

    #[Test]
    public function writesToOutputWhenShowCalledIfHidden(): void
    {
        $cursorMode = CursorMode::HIDDEN;

        $buffer = $this->getBufferMock();

        $showSequence = "\x1b[?25h\x1b[?0c";
        $buffer
            ->expects(self::once())
            ->method('append')
            ->with($showSequence)
            ->willReturnSelf()
        ;

        $cursor = $this->getTesteeInstance(buffer: $buffer, cursorMode: $cursorMode);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue($cursor, 'cursorVisibilityMode'));

        $cursor->show();
    }

    #[Test]
    public function writesToBufferWhenMoveLeftAndFlushCalled(): void
    {
        $buffer = $this->getBufferMock();

        $moveLeftSequence = "\x1b[2D";

        $buffer->expects(self::once())->method('append')->with($moveLeftSequence);
        $buffer->expects(self::never())->method('flush');

        $cursor = $this->getTesteeInstance(buffer: $buffer);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);

        $cursor->moveLeft(2);
    }

    #[Test]
    public function writesToBufferWhenEraseAndFlushCalled(): void
    {
        $buffer = $this->getBufferMock();

        $eraseSequence = "\x1b[2X";

        $buffer->expects(self::once())->method('append')->with($eraseSequence);
        $buffer->expects(self::never())->method('flush');

        $cursor = $this->getTesteeInstance(buffer: $buffer);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);

        $cursor->erase(2);
    }

    protected function getOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }
}
