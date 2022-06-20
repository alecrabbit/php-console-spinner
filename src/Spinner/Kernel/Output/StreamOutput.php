<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Output;

use AlecRabbit\Spinner\Kernel\Exception\RuntimeException;
use AlecRabbit\Spinner\Kernel\Output\Contract\IOutput;

use function fflush;
use function fwrite;
use function get_debug_type;
use function get_resource_type;
use function is_iterable;
use function is_resource;
use function is_string;
use function sprintf;

use const PHP_EOL;

final class StreamOutput implements IOutput
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @throws RuntimeException
     */
    public function __construct($stream)
    {
        self::assertStream($stream);
        $this->stream = $stream;
    }

    /**
     * @throws RuntimeException
     */
    private static function assertStream(mixed $stream): void
    {
        if (!is_resource($stream) || 'stream' !== get_resource_type($stream)) {
            throw new RuntimeException(
                sprintf('Argument 1 expected to be a stream, [%s] given', get_debug_type($stream))
            );
        }
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
                if ($newline) {
                    $message .= PHP_EOL;
                }
                if (false === @fwrite($this->stream, $message)) {
                    // should never happen
                    throw new RuntimeException('Was unable to write to stream.');
                }
            }
        }
        fflush($this->stream);
    }
}
