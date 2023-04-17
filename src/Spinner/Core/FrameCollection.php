<?php

declare(strict_types=1);

// 20.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;
use Traversable;

/**
 * @template T of IFrame
 * @extends ArrayObject<int,T>
 * @implements IFrameCollection<T>
 */
final class FrameCollection extends ArrayObject implements IFrameCollection
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(Traversable $frames)
    {
        parent::__construct();
        $this->initialize($frames);
        self::assertIsNotEmpty($this);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function initialize(Traversable $frames): void
    {
        /** @var T $frame */
        foreach ($frames as $frame) {
            self::assertFrame($frame);
            $this->append($frame);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertFrame(mixed $frame): void
    {
        if (!$frame instanceof IFrame) {
            throw new InvalidArgumentException(
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
        if (0 === $collection->count()) {
            throw new InvalidArgumentException('Collection is empty.');
        }
    }

    /** @inheritdoc */
    public function lastIndex(): int
    {
        return array_key_last($this->getArrayCopy());
    }

    public function get(int $index): IFrame
    {
        return $this->offsetGet($index);
    }
}
