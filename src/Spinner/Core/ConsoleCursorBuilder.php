<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use LogicException;

final class ConsoleCursorBuilder implements IConsoleCursorBuilder
{
    protected ?IOutput $output = null;
    protected ?OptionCursor $cursorOption = null;

    public function build(): IConsoleCursor
    {
        $this->assert();

        return
            new ConsoleCursor(
                $this->output,
                $this->cursorOption,
            );
    }

    private function assert(): void
    {
        $this->assertOutput($this->output);
        $this->assertCursorOption($this->cursorOption);
    }

    private function assertOutput(?IOutput $output): void
    {
        if (null === $output) {
            throw new LogicException('Output is not set');
        }
    }

    private function assertCursorOption(?OptionCursor $cursorOption): void
    {
        if (null === $cursorOption) {
            throw new LogicException('CursorOption is not set');
        }
    }

    public function withOutput(IOutput $output): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withCursorOption(OptionCursor $getCursorOption): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->cursorOption = $getCursorOption;
        return $clone;
    }
}
