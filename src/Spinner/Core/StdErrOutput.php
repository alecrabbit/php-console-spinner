<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

final class StdErrOutput implements Core\Contract\IOutput
{
    /**
     * @var resource
     */
    private $stream;

    public function __construct(
        $stream = STDERR,
    ) {
        if (!is_resource($stream)) {
            throw new \RuntimeException(
                sprintf('Stream expected to be a resource, [%s] given', get_debug_type($stream))
            );
        }
        $this->stream = $stream;
    }

    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            if (false === @fwrite($this->stream, $message)) {
                // should never happen
                throw new \RuntimeException('Was unable to write to stream.');
            }
        }
        fflush($this->stream);
    }

    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->write($messages, true, $options);
    }
}
