<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\A\AOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IStringBuffer;

final class StreamBufferedOutput extends AOutput implements IBufferedOutput
{
    public function __construct(
        IResourceStream $stream,
        protected readonly IStringBuffer $buffer = new StringBuffer()
    ) {
        parent::__construct($stream);
    }

    public function flush(): void
    {
        $this->doWrite($this->buffer->flush());
    }

    public function bufferedWrite(iterable|string $messages, bool $newline = false): IBufferedOutput
    {
        $this->buffer->write($this->homogenize($messages, $newline));

        return $this;
    }
}
