<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\Contract\IStringBuffer;
use Generator;
use Traversable;

use function is_iterable;
use function is_string;

use const PHP_EOL;

final readonly class StreamBufferedOutput implements IBufferedOutput
{
    public function __construct(
        private IResourceStream $stream,
        private IStringBuffer $buffer = new StringBuffer()
    ) {
    }

    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->write($messages, true, $options);
    }

    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
    {
        $this->doWrite($this->homogenize($messages, $newline));
    }

    private function doWrite(Traversable $data): void
    {
        $this->stream->write($data);
    }

    /**
     * @codeCoverageIgnore Generator is not iterated through during tests.
     *
     * @return Generator<string>
     */
    private function homogenize(iterable|string $messages, bool $newline = false): Generator
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        /** @var string $message */
        foreach ($messages as $message) {
            /** @psalm-suppress RedundantConditionGivenDocblockType */
            if (is_string($message)) {
                if ($newline) {
                    $message .= PHP_EOL;
                }
                yield $message;
            }
        }
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
