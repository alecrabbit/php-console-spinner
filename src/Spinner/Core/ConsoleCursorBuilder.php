<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use LogicException;

final class ConsoleCursorBuilder implements IConsoleCursorBuilder
{
    private ?IOutput $output = null;
    private ?OptionCursor $cursorOption = null;

    public function build(): IConsoleCursor
    {
        $this->validate();

        return new ConsoleCursor(
            $this->output,
            $this->cursorOption,
        );
    }

    private function validate(): void
    {
        match (true) {
            null === $this->output => throw new LogicException('Output is not set.'),
            $this->cursorOption === null => throw new LogicException('CursorOption is not set.'),
            default => null,
        };
    }

    public function withOutput(IOutput $output): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withOptionCursor(OptionCursor $getCursorOption): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->cursorOption = $getCursorOption;
        return $clone;
    }
}
