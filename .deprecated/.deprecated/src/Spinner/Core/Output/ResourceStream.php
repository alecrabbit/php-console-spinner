<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IResourceStream;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;
use Traversable;

/**
 * @codeCoverageIgnore Not testable
 */
final class ResourceStream implements IResourceStream
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @param resource $stream
     * @throws InvalidArgumentException
     */
    public function __construct(
        $stream
    ) {
        Asserter::assertStream($stream);
        $this->stream = $stream;
    }

    /** @inheritDoc */
    public function write(Traversable $data): void
    {
        /** @var string $item */
        foreach ($data as $item) {
            if (false === @fwrite($this->stream, $item)) {
                // should never happen
                throw new RuntimeException('Was unable to write to a stream.');
            }
        }
        fflush($this->stream);
    }
}
