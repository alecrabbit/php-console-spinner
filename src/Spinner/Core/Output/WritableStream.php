<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Traversable;

final class WritableStream implements IWritableStream
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @throws InvalidArgument
     */
    public function __construct(mixed $stream)
    {
        if (!is_resource($stream) || get_resource_type($stream) !== 'stream') {
            throw new InvalidArgument(
                sprintf(
                    'Argument is expected to be a stream(resource), "%s" given.',
                    get_debug_type($stream)
                )
            );
        }

        $this->stream = $stream;
    }

    /**
     * @codeCoverageIgnore
     *
     * @inheritDoc
     */
    public function write(Traversable $data): void
    {
        /** @var string $item */
        foreach ($data as $item) {
            if (fwrite($this->stream, $item) === false) {
                throw new RuntimeException('Was unable to write to a stream.');
            }
        }
        // fflush($this->stream);
    }
}
