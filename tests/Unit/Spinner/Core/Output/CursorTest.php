<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CursorTest extends TestCase
{
    #[Test]
    public function isCreatedWithGivenOption(): void
    {
        $cursorOption = OptionCursor::VISIBLE;

        $cursor = $this->getTesteeInstance(output: null, cursorOption: $cursorOption);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorOption, self::getPropertyValue('optionCursor', $cursor));
    }

    public function getTesteeInstance(
        (MockObject & IBufferedOutput)|null $output,
        OptionCursor $cursorOption = OptionCursor::HIDDEN,
    ): IConsoleCursor {
        return new ConsoleCursor(
            output: $output ?? $this->getOutputMock(),
            optionCursor: $cursorOption,
        );
    }

    protected function getOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    #[Test]
    public function writesToOutputWhenHideCalledIfHidden(): void
    {
        $cursorOption = OptionCursor::HIDDEN;

        $output = $this->getOutputMock();

        $hideSequence = "\x1b[?25l";
        $output->expects(self::once())->method('write')->with($hideSequence);

        $cursor = $this->getTesteeInstance(output: $output, cursorOption: $cursorOption);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorOption, self::getPropertyValue('optionCursor', $cursor));

        $cursor->hide();
    }

    #[Test]
    public function doesNotWriteToOutputWhenHideOrShowCalledIfEnabled(): void
    {
        $cursorOption = OptionCursor::VISIBLE;

        $output = $this->getOutputMock();

        $output->expects(self::never())->method('write');

        $cursor = $this->getTesteeInstance(output: $output, cursorOption: $cursorOption);

        self::assertSame($cursorOption, self::getPropertyValue('optionCursor', $cursor));

        $cursor->hide();
        $cursor->show();
    }

    #[Test]
    public function writesToOutputWhenShowCalledIfHidden(): void
    {
        $cursorOption = OptionCursor::HIDDEN;

        $output = $this->getOutputMock();

        $showSequence = "\x1b[?25h\x1b[?0c";
        $output->expects(self::once())->method('write')->with($showSequence);

        $cursor = $this->getTesteeInstance(output: $output, cursorOption: $cursorOption);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);
        self::assertSame($cursorOption, self::getPropertyValue('optionCursor', $cursor));

        $cursor->show();
    }

    #[Test]
    public function writesToBufferWhenMoveLeftAndFlushCalled(): void
    {
        $output = $this->getOutputMock();

        $moveLeftSequence = "\x1b[2D";

        $output->expects(self::once())->method('bufferedWrite')->with($moveLeftSequence);
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

        $output->expects(self::once())->method('bufferedWrite')->with($eraseSequence);
        $output->expects(self::once())->method('flush');

        $cursor = $this->getTesteeInstance(output: $output);

        self::assertInstanceOf(ConsoleCursor::class, $cursor);

        $cursor->erase(2)->flush();
    }
}