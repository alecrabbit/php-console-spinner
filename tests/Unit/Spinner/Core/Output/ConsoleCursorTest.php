<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
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
        $cursorMode = CursorVisibilityMode::VISIBLE;

        $cursor = $this->getTesteeInstance(
            cursorMode: $cursorMode
        );

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));
    }

    public function getTesteeInstance(
        ?IBuffer $buffer = null,
        CursorVisibilityMode $cursorMode = CursorVisibilityMode::HIDDEN,
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
        $cursorMode = CursorVisibilityMode::HIDDEN;

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
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));

        $cursor->hide();
    }

    #[Test]
    public function doesNotWriteToOutputWhenHideOrShowCalledIfEnabled(): void
    {
        $cursorMode = CursorVisibilityMode::VISIBLE;

        $buffer = $this->getBufferMock();
        $buffer
            ->expects(self::never())
            ->method('append')
        ;

        $cursor = $this->getTesteeInstance(buffer: $buffer, cursorMode: $cursorMode);

        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));

        $cursor->hide();
        $cursor->show();
    }

    #[Test]
    public function writesToOutputWhenShowCalledIfHidden(): void
    {
        $cursorMode = CursorVisibilityMode::HIDDEN;

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
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));

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
