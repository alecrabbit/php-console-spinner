<?php

declare(strict_types=1);

// 10.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Output\DriverOutput;
use AlecRabbit\Spinner\Exception\LogicException;

final class DriverOutputBuilder implements IDriverOutputBuilder
{
    protected ?IBufferedOutput $bufferedOutput = null;
    protected ?IConsoleCursor $cursor = null;

    public function build(): IDriverOutput
    {
        $this->validate();

        return
            new DriverOutput(
                output: $this->bufferedOutput,
                cursor: $this->cursor,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->bufferedOutput => throw new LogicException('Output is not set.'),
            null === $this->cursor => throw new LogicException('Cursor is not set.'),
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
