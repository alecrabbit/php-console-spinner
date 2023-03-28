<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Contract\IOutputBuffer;

final readonly class Cursor implements ICursor
{
    public function __construct(
        protected IOutput $output,
        protected OptionCursor $cursorOption,
    ) {
    }

    public function hide(?IOutputBuffer $buffer = null): ICursor
    {
        if ($this->isHidden()) {
            $this->bufferedWrite($buffer, "\x1b[?25l");
        }

        return $this;
    }

    protected function isHidden(): bool
    {
        return OptionCursor::HIDDEN === $this->cursorOption;
    }

    public function show(?IOutputBuffer $buffer = null): ICursor
    {
        if ($this->isHidden()) {
            $this->bufferedWrite($buffer, "\x1b[?25h\x1b[?0c");
        }

        return $this;
    }

    private function bufferedWrite(?IOutputBuffer $buffer, string $message): void
    {
        match ($buffer instanceof IOutputBuffer) {
            true => $buffer->write($message),
            false => $this->output->write($message),
        };
    }

    public function moveLeft(int $columns = 1, ?IOutputBuffer $buffer = null): ICursor
    {
        $this->bufferedWrite($buffer, "\x1b[{$columns}D");

        return $this;
    }
}