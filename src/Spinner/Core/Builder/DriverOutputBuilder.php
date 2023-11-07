<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Output\DriverOutput;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class DriverOutputBuilder implements IDriverOutputBuilder
{
    private ?IBufferedOutput $bufferedOutput = null;
    private ?IConsoleCursor $cursor = null;

    public function build(): IDriverOutput
    {
        $this->validate();

        return new DriverOutput(
            output: $this->bufferedOutput,
            cursor: $this->cursor,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->bufferedOutput === null => throw new LogicException('Output is not set.'),
            $this->cursor === null => throw new LogicException('Cursor is not set.'),
            default => null,
        };
    }

    public function withOutput(IBufferedOutput $bufferedOutput): IDriverOutputBuilder
    {
        $clone = clone $this;
        $clone->bufferedOutput = $bufferedOutput;
        return $clone;
    }

    public function withCursor(IConsoleCursor $cursor): IDriverOutputBuilder
    {
        $clone = clone $this;
        $clone->cursor = $cursor;
        return $clone;
    }
}
