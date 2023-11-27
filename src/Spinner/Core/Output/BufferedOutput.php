<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;

final readonly class BufferedOutput implements IBufferedOutput
{
    public function __construct(
        protected IOutput $output,
        protected IBuffer $buffer,
    ) {
    }

    public function flush(): void
    {
        $this->output->write($this->buffer->flush());
    }

    public function append(iterable|string $messages): IBufferedOutput
    {
        $this->buffer->append($messages);

        return $this;
    }
}
