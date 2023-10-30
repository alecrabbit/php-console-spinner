<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\A\AOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;

// FIXME (2023-10-30 15:59) [Alec Rabbit]: make this class an adapter for Output
//  public function __construct(
//      IOutput $output,
//      protected readonly IStringBuffer $buffer = new StringBuffer()
//  ) {
//      //...
//  }
final class BufferedOutput extends AOutput implements IBufferedOutput
{
    public function __construct(
        IResourceStream $stream,
        protected readonly IBuffer $buffer,
    ) {
        parent::__construct($stream);
    }

    public function flush(): void
    {
        $this->doWrite($this->buffer->flush());
    }

    public function append(iterable|string $messages, bool $newline = false): IBufferedOutput
    {
        $this->buffer->append($this->homogenize($messages, $newline));

        return $this;
    }
}
