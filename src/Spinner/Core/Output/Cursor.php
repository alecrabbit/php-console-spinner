<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

final readonly class Cursor implements ICursor
{
    public function __construct(
        protected IBufferedOutput $output,
        protected OptionCursor $cursorOption,
    ) {
    }

    public function hide(): ICursor
    {
        if ($this->isHidden()) {
            $this->output->write("\x1b[?25l");

        }

        return $this;
    }

    protected function isHidden(): bool
    {
        return OptionCursor::HIDDEN === $this->cursorOption;
    }

    public function show(): ICursor
    {
        if ($this->isHidden()) {
            $this->output->write("\x1b[?25h\x1b[?0c");

        }

        return $this;
    }

    public function moveLeft(int $columns = 1): ICursor
    {
        $this->output->write("\x1b[{$columns}D");


        return $this;
    }
}