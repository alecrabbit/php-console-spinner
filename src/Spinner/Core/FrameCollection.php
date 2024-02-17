<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use ArrayObject;
use Traversable;

/**
 * Finite collection of frames.
 */
final class FrameCollection implements IFrameCollection
{
    private const COLLECTION_IS_EMPTY = 'Collection is empty.';

    /** @var ArrayObject<int, ISequenceFrame> */
    private ArrayObject $frames;
    private int $count;

    /**
     * @param Traversable<ISequenceFrame> $frames Should be a finite set of frames.
     * @param int $index Starting index of a collection.
     *
     * @throws InvalidArgument
     */
    public function __construct(
        Traversable $frames,
        private int $index = 0,
    ) {
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->frames = new ArrayObject();

        /**
         * @var ISequenceFrame $frame
         */
        foreach ($frames as $frame) {
            self::assertFrame($frame);
            $this->frames->append($frame);
        }

        $this->count = $this->frames->count();

        if ($this->index >= $this->count) {
            $this->index = 0;
        }

        self::assertIsNotEmpty($this);
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertFrame(mixed $frame): void
    {
        if (!$frame instanceof ISequenceFrame) {
            throw new InvalidArgument(
                sprintf(
                    'Frame should be an instance of "%s". "%s" given.',
                    ISequenceFrame::class,
                    get_debug_type($frame)
                )
            );
        }
    }

    public function count(): int
    {
        return $this->count;
    }

    private static function assertIsNotEmpty(IFrameCollection $collection): void
    {
        if ($collection->count() === 0) {
            throw new InvalidArgument(self::COLLECTION_IS_EMPTY);
        }
    }

    public function next(): void
    {
        if ($this->count === 1 || ++$this->index === $this->count) {
            $this->index = 0;
        }
    }

    public function current(): ISequenceFrame
    {
        return $this->frames->offsetGet($this->index);
    }
}
