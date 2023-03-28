<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IOutputBuffer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;

use function fflush;
use function fwrite;
use function is_iterable;
use function is_string;

use const PHP_EOL;

final class StreamOutput implements IOutput
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @param resource $stream
     * @throws InvalidArgumentException
     */
    public function __construct($stream)
    {
        Asserter::assertStream($stream);
        $this->stream = $stream;
    }

    /**
     * @throws RuntimeException
     */
    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->write($messages, true, $options);
    }

    /**
     * @throws RuntimeException
     */
    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
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
                if (false === @fwrite($this->stream, $message)) {
                    // should never happen
                    throw new RuntimeException('Was unable to write to a stream.');
                }
            }
        }
        fflush($this->stream);
    }

    public function createBuffer(): IOutputBuffer
    {
        return new OutputBuffer($this);
    }
}
