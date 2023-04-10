<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Output\DriverOutput;
use AlecRabbit\Spinner\Exception\LogicException;

final class DriverOutputBuilder implements IDriverOutputBuilder
{
    protected ?IBufferedOutput $output = null;
    protected ?ICursor $cursor = null;

    public function build(): IDriverOutput
    {
        $this->validate();

        return
            new DriverOutput(
                output: $this->output,
                cursor: $this->cursor,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->output => throw new LogicException('Output is not defined.'),
            null === $this->cursor => throw new LogicException('Cursor is not defined.'),
            default => null,
        };
    }
}
