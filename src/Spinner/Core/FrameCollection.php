<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use ArrayObject;
use Traversable;

/**
 * @template T of IFrame
 *
 * @extends ArrayObject<int,T>
 *
 * @implements IFrameCollection<T>
 */
final class FrameCollection extends ArrayObject implements IFrameCollection
{
    private const COLLECTION_IS_EMPTY = 'Collection is empty.';

    /**
     * @throws InvalidArgument
     */
    public function __construct(Traversable $frames)
    {
        parent::__construct();
        $this->initialize($frames);
        self::assertIsNotEmpty($this);
    }

    /**
     * @throws InvalidArgument
     */
    private function initialize(Traversable $frames): void
    {
        /**
         * @var T $frame
         */
        foreach ($frames as $frame) {
            self::assertFrame($frame);
            $this->append($frame);
        }
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertFrame(mixed $frame): void
    {
        if (!$frame instanceof IFrame) {
            throw new InvalidArgument(
                sprintf(
                    '"%s" expected, "%s" given.',
                    IFrame::class,
                    get_debug_type($frame)
                )
            );
        }
    }

    private static function assertIsNotEmpty(IFrameCollection $collection): void
    {
        if ($collection->count() === 0) {
            throw new InvalidArgument(self::COLLECTION_IS_EMPTY);
        }
    }

    public function lastIndex(): int
    {
        $index = array_key_last($this->getArrayCopy());

        // @codeCoverageIgnoreStart
        if ($index === null) {
            // should not be thrown
            throw new LogicException(self::COLLECTION_IS_EMPTY);
        }
        // @codeCoverageIgnoreEnd

        return $index;
    }

    public function get(int $index): IFrame
    {
        return $this->offsetGet($index);
    }

    public function next(): void
    {
        // TODO: Implement next() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }

    public function current(): IFrame
    {
        // TODO: Implement current() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
