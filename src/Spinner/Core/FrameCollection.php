<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use ArrayAccess;
use ArrayObject;
use Traversable;

/**
 * @template T of IFrame
 * @template-implements ArrayAccess<int,T>
 */
final class FrameCollection extends ArrayObject implements IFrameCollection
{
    public function __construct(Traversable $frames)
    {
        parent::__construct(
            iterator_to_array($frames)
        );
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
