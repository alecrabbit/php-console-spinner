<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;
use Traversable;

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
        foreach ($frames as $frame) {
            self::assertFrame($frame);
            $this->append($frame);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertFrame($frame): void
    {
        if (!$frame instanceof IFrame) {
            throw new InvalidArgumentException(
                sprintf(
                    'Frame must be instance of %s. %s given.',
                    IFrame::class,
                    get_debug_type($frame)
                )
            );
        }
    }

    public function lastIndex(): ?int
    {
        return array_key_last($this->getArrayCopy());
    }

    public function get(int $index): IFrame
    {
        return $this->offsetGet($index);
    }
}
