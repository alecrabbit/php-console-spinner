<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\A;

use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use Generator;
use Traversable;

abstract class AOutput implements IOutput
{
    public function __construct(
        protected readonly IResourceStream $stream,
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

    /**
     * @param Traversable<string> $data
     */
    protected function doWrite(Traversable $data): void
    {
        $this->stream->write($data);
    }

    /**
     * @codeCoverageIgnore Generator is not iterated through during tests.
     *
     * @return Generator<string>
     */
    protected function homogenize(iterable|string $messages, bool $newline = false): Generator
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
