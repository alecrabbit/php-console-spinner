<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use LogicException;

final class ConsoleCursorBuilder implements IConsoleCursorBuilder
{
    private ?IOutput $output = null;
    private ?CursorVisibilityMode $cursorVisibilityMode = null;

    public function build(): IConsoleCursor
    {
        $this->validate();

        return
            new ConsoleCursor(
                $this->output,
                $this->cursorVisibilityMode,
            );
    }

    private function validate(): void
    {
        match (true) {
            null === $this->output => throw new LogicException('Output is not set.'),
            $this->cursorVisibilityMode === null => throw new LogicException('CursorOption is not set.'),
            default => null,
        };
    }

    public function withOutput(IOutput $output): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->output = $output;
        return $clone;
    }

    public function withCursorVisibilityMode(CursorVisibilityMode $cursorVisibilityMode): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->cursorVisibilityMode = $cursorVisibilityMode;
        return $clone;
    }
}
