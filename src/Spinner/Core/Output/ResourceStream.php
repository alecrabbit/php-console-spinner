<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;
use Traversable;

/**
 * @codeCoverageIgnore
 */
final class ResourceStream implements IResourceStream
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @param resource $stream
     *
     * @throws InvalidArgumentException
     */
    public function __construct(mixed $stream)
    {
        Asserter::assertStream($stream);
        $this->stream = $stream;
    }

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
