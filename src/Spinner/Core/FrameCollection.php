<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\DomainException;
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
    }

    /**
     * @throws InvalidArgumentException
     */
    private function initialize(Traversable $frames): void
    {
        /** @var IFrame $frame */
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
                    'Frame must be instance of %s. %s given.', // TODO: clarify message
                    IFrame::class,
                    get_debug_type($frame)
                )
            );
        }
    }

    /** @inheritdoc */
    public function lastIndex(): int
    {
        return
            array_key_last($this->getArrayCopy())
            ??
            throw new DomainException('Empty collection.');
    }

    /** @psalm-suppress MixedInferredReturnType */
    public function get(int $index): IFrame
    {
        /** @psalm-suppress MixedReturnStatement */
        return $this->offsetGet($index);
    }
}
