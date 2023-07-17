<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

final readonly class ConsoleCursor implements IConsoleCursor
{
    public function __construct(
        protected IBufferedOutput $output,
        protected CursorVisibilityMode $cursorVisibilityMode,
    ) {
    }

    public function hide(): IConsoleCursor
    {
        if ($this->isHideCursorEnabled()) {
            $this->output->write("\x1b[?25l");
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
            $this->output->write("\x1b[?25h\x1b[?0c");
        }

        return $this;
    }

    public function moveLeft(int $columns = 1): IConsoleCursor
    {
        $this->output->bufferedWrite("\x1b[{$columns}D");

        return $this;
    }

    public function erase(int $width = 1): IConsoleCursor
    {
        $this->output->bufferedWrite("\x1b[{$width}X");

        return $this;
    }

    public function flush(): IConsoleCursor
    {
        $this->output->flush();

        return $this;
    }
}
