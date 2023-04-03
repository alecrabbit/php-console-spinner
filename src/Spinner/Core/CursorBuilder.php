<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Contract\ICursorBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Cursor;
use LogicException;

final class CursorBuilder implements ICursorBuilder
{
    protected ?IOutput $output = null;
    protected ?OptionCursor $cursorOption = null;

    public function build(): ICursor
    {
        $this->assert();

        return
            new Cursor(
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

    public function withOutput(IOutput $output): ICursorBuilder
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withCursorOption(OptionCursor $getCursorOption): ICursorBuilder
    {
        $clone = clone $this;
        $clone->cursorOption = $getCursorOption;
        return $clone;
    }
}