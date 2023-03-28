<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Cursor;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CursorTest extends TestCase
{
    #[Test]
    public function isCreatedWithGivenOption(): void
    {
        $cursorOption = OptionCursor::ENABLED;

        $cursor = $this->getTesteeInstance(output: null, cursorOption: $cursorOption);

        self::assertInstanceOf(Cursor::class, $cursor);
        self::assertSame($cursorOption, self::getValue('cursorOption', $cursor));
    }

    public function getTesteeInstance(
        (MockObject&IBufferedOutput)|null $output,
        OptionCursor $cursorOption = OptionCursor::HIDDEN,
    ): ICursor {
        return
            new Cursor(
                output: $output ?? $this->getOutputMock(),
                cursorOption: $cursorOption,
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

        self::assertInstanceOf(Cursor::class, $cursor);
        self::assertSame($cursorOption, self::getValue('cursorOption', $cursor));

        $cursor->hide();
    }

    #[Test]
    public function doesNotWriteToOutputWhenHideOrShowCalledIfEnabled(): void
    {
        $cursorOption = OptionCursor::ENABLED;

        $output = $this->getOutputMock();

        $output->expects(self::never())->method('write');

        $cursor = $this->getTesteeInstance(output: $output, cursorOption: $cursorOption);

        self::assertSame($cursorOption, self::getValue('cursorOption', $cursor));

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

        self::assertInstanceOf(Cursor::class, $cursor);
        self::assertSame($cursorOption, self::getValue('cursorOption', $cursor));

        $cursor->show();
    }

    #[Test]
    public function writesToOutputWhenMoveLeftCalled(): void
    {
        $output = $this->getOutputMock();

        $moveLeftSequence = "\x1b[2D";

        $output->expects(self::once())->method('write')->with($moveLeftSequence);

        $cursor = $this->getTesteeInstance(output: $output);

        self::assertInstanceOf(Cursor::class, $cursor);

        $cursor->moveLeft(2);
    }
}
