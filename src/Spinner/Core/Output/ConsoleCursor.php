<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

final readonly class ConsoleCursor implements IConsoleCursor
{
    public function __construct(
        protected IBuffer $buffer,
        protected CursorVisibilityMode $cursorVisibilityMode,
    ) {
    }

    public function hide(): IConsoleCursor
    {
        if ($this->isHideCursorEnabled()) {
            $this->buffer->append("\x1b[?25l");
        }

        return $this;
    }

    private function isHideCursorEnabled(): bool
    {
        return $this->cursorVisibilityMode === CursorVisibilityMode::HIDDEN;
    }

    public function show(): IConsoleCursor
    {
        if ($this->isHideCursorEnabled()) {
            $this->buffer->append("\x1b[?25h\x1b[?0c");
        }

        return $this;
    }

    public function moveLeft(int $columns = 1): IConsoleCursor
    {
        $this->buffer->append("\x1b[{$columns}D");

        return $this;
    }

    public function erase(int $width = 1): IConsoleCursor
    {
        $this->buffer->append("\x1b[{$width}X");

        return $this;
    }
}
