<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Traversable;

final class ResourceStream implements IResourceStream
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @param mixed $stream
     *
     * @throws InvalidArgumentException
     */
    public function __construct(mixed $stream)
    {
        if (!is_resource($stream) || get_resource_type($stream) !== 'stream') {
            throw new InvalidArgumentException(
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
     */
    public function write(Traversable $data): void
    {
        /** @var string $item */
        foreach ($data as $item) {
            if (fwrite($this->stream, $item) === false) {
                throw new RuntimeException('Was unable to write to a stream.');
            }
        }
        fflush($this->stream);
    }
}
