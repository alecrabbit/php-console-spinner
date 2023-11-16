<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Spinner\Core\Output\SequenceStateWriter;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class SequenceStateWriterBuilder implements ISequenceStateWriterBuilder
{
    private ?IBufferedOutput $bufferedOutput = null;
    private ?IConsoleCursor $cursor = null;

    public function build(): ISequenceStateWriter
    {
        $this->validate();

        return new SequenceStateWriter(
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

    public function withOutput(IBufferedOutput $bufferedOutput): ISequenceStateWriterBuilder
    {
        $clone = clone $this;
        $clone->bufferedOutput = $bufferedOutput;
        return $clone;
    }

    public function withCursor(IConsoleCursor $cursor): ISequenceStateWriterBuilder
    {
        $clone = clone $this;
        $clone->cursor = $cursor;
        return $clone;
    }
}
