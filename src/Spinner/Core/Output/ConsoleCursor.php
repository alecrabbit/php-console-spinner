<?php

declare(strict_types=1);

// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

final readonly class ConsoleCursor implements IConsoleCursor
{
    public function __construct(
        protected IBufferedOutput $output,
        protected OptionCursor $optionCursor,
    ) {
    }

    public function hide(): IConsoleCursor
    {
        if ($this->isHideCursorEnabled()) {
            $this->output->write("\x1b[?25l");
        }

        return $this;
    }

    protected function isHideCursorEnabled(): bool
    {
        return OptionCursor::HIDDEN === $this->optionCursor;
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
