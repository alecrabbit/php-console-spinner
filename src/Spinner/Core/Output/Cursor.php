<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

final readonly class Cursor implements ICursor
{
    public function __construct(
        protected IOutput $output,
        protected OptionCursor $option = OptionCursor::DISABLED,
    ) {
    }

    public function hide(): ICursor
    {   
        if ($this->isDisabled()) {
            return $this;
        }
        
        $this->output->write("\x1b[?25l");

        return $this;
    }

    public function show(): ICursor
    {
        if ($this->isDisabled()) {
            return $this;
        }
        
        $this->output->write("\x1b[?25h\x1b[?0c");

        return $this;
    }

    private function isDisabled(): bool
    {
        return OptionCursor::DISABLED === $this->option;
    }
}