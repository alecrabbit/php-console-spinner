<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class ConsoleCursorBuilder implements IConsoleCursorBuilder
{
    private ?CursorMode $cursorVisibilityMode = null;
    private ?IBuffer $buffer = null;

    public function build(): IConsoleCursor
    {
        $this->validate();

        return new ConsoleCursor(
            $this->buffer,
            $this->cursorVisibilityMode,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->buffer === null => throw new LogicException('Buffer is not set.'),
            $this->cursorVisibilityMode === null => throw new LogicException('CursorMode is not set.'),
            default => null,
        };
    }

    public function withBuffer(IBuffer $buffer): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->buffer = $buffer;
        return $clone;
    }

    public function withCursorMode(CursorMode $cursorVisibilityMode): IConsoleCursorBuilder
    {
        $clone = clone $this;
        $clone->cursorVisibilityMode = $cursorVisibilityMode;
        return $clone;
    }
}
