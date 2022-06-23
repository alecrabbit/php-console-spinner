<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class ACharFrameCollection extends AIntervalCollection implements ICharFrameCollection
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(array $frames, IInterval $interval): ICharFrameCollection
    {
        return new static($frames, $interval);
    }

    protected static function getElementClass(): string
    {
        return ICharFrame::class;
    }

    public function next(): ICharFrame
    {
        return $this->nextElement();
    }
}
