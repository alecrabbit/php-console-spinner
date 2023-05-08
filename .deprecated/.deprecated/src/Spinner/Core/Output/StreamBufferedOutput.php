<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\IResourceStream;
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

    /** @inheritdoc */
    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->write($messages, true, $options);
    }

    /** @inheritdoc */
    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
    {
        $this->doWrite($this->homogenize($messages, $newline));
    }

    protected function doWrite(Traversable $data): void
    {
        $this->stream->write($data);
    }

    /**
     * @codeCoverageIgnore Generator is not iterated through during tests.
     *
     * @param iterable|string $messages
     * @param bool $newline
     * @return Generator<string>
     */
    protected function homogenize(iterable|string $messages, bool $newline = false): Generator
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

    /** @inheritdoc */
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
