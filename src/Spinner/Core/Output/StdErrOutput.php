<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Exception\RuntimeException;

final class StdErrOutput implements Contract\IOutput
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @throws RuntimeException
     */
    public function __construct(
        $stream = STDERR,
    ) {
        if (!is_resource($stream)) {
            throw new RuntimeException(
                sprintf('Stream expected to be a resource, [%s] given', get_debug_type($stream))
            );
        }
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
        foreach ($messages as $message) {
            if (is_string($message)) {
                if (false === @fwrite($this->stream, $message)) {
                    // should never happen
                    throw new RuntimeException('Was unable to write to stream.');
                }
            }
        }
        fflush($this->stream);
    }
}
