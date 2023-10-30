<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
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
            output: null,
            cursorMode: $cursorMode
        );

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));
    }

    public function getTesteeInstance(
        (MockObject & IBufferedOutput)|null $output,
        CursorVisibilityMode $cursorMode = CursorVisibilityMode::HIDDEN,
    ): IConsoleCursor {
        return
            new ConsoleCursor(
                output: $output ?? $this->getOutputMock(),
                cursorVisibilityMode: $cursorMode,
            );
    }

    protected function getOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    #[Test]
    public function writesToOutputWhenHideCalledIfHidden(): void
    {
        $cursorMode = CursorVisibilityMode::HIDDEN;

        $output = $this->getOutputMock();

        $hideSequence = "\x1b[?25l";
        $output
            ->expects(self::once())
            ->method('append')
            ->with($hideSequence)
            ->willReturnSelf()
        ;

        $cursor = $this->getTesteeInstance(output: $output, cursorMode: $cursorMode);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));

        $cursor->hide();
    }

    #[Test]
    public function doesNotWriteToOutputWhenHideOrShowCalledIfEnabled(): void
    {
        $cursorMode = CursorVisibilityMode::VISIBLE;

        $output = $this->getOutputMock();

        $output->expects(self::never())->method('write');

        $cursor = $this->getTesteeInstance(output: $output, cursorMode: $cursorMode);

        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));

        $cursor->hide();
        $cursor->show();
    }

    #[Test]
    public function writesToOutputWhenShowCalledIfHidden(): void
    {
        $cursorMode = CursorVisibilityMode::HIDDEN;

        $output = $this->getOutputMock();

        $showSequence = "\x1b[?25h\x1b[?0c";
        $output->expects(self::once())->method('write')->with($showSequence);

        $cursor = $this->getTesteeInstance(output: $output, cursorMode: $cursorMode);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $cursor));

        $cursor->show();
    }

    #[Test]
    public function writesToBufferWhenMoveLeftAndFlushCalled(): void
    {
        $output = $this->getOutputMock();

        $moveLeftSequence = "\x1b[2D";

        $output->expects(self::once())->method('append')->with($moveLeftSequence);
        $output->expects(self::once())->method('flush');

        $cursor = $this->getTesteeInstance(output: $output);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);

        $cursor->moveLeft(2)->flush();
    }

    #[Test]
    public function writesToBufferWhenEraseAndFlushCalled(): void
    {
        $output = $this->getOutputMock();

        $eraseSequence = "\x1b[2X";

        $output->expects(self::once())->method('append')->with($eraseSequence);
        $output->expects(self::once())->method('flush');

        $cursor = $this->getTesteeInstance(output: $output);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);

        $cursor->erase(2)->flush();
    }
}
