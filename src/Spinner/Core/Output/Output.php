<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use Traversable;

final readonly class Output implements IOutput
{
    public function __construct(
        protected IWritableStream $stream,
    ) {
    }

    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->write($messages, true, $options);
    }

    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
    {
        $this->stream->write(
            $this->homogenize($messages, $newline)
        );
    }

    /**
     * @return Traversable<string>
     */
    protected function homogenize(iterable|string $messages, bool $newline = false): Traversable
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        /** @var mixed $message */
        foreach ($messages as $message) {
            if (is_string($message)) {
                if ($newline) {
                    $message .= PHP_EOL;
                }
                yield $message;
            }
        }
    }
}
