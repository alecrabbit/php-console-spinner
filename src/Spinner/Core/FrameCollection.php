<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
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

    /** @var ArrayObject<int, IFrame> */
    private ArrayObject $frames;
    private int $count;

    /**
     * @param Traversable<IFrame> $frames Should be a finite set of frames.
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
         * @var IFrame $frame
         */
        foreach ($frames as $frame) {
            self::assertFrame($frame);
            $this->frames->append($frame);
        }

        $this->count = $this->frames->count();

        self::assertIsNotEmpty($this);
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertFrame(mixed $frame): void
    {
        if (!$frame instanceof IFrame) {
            throw new InvalidArgument(
                sprintf(
                    'Frame should be an instance of "%s". "%s" given.',
                    IFrame::class,
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

    public function current(): IFrame
    {
        return $this->frames->offsetGet($this->index);
    }
}
