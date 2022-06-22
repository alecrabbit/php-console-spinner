<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class AStyleFrameCollection extends ACollection implements IStyleFrameCollection
{
    protected function __construct(
        iterable $elements,
        public readonly IInterval $interval,
    ) {
        parent::__construct($elements);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(array $frames, IInterval $interval): IStyleFrameCollection
    {
        return new static($frames, $interval);
    }

    protected static function getElementClass(): string
    {
        return IStyleFrame::class;
    }

    public function next(): IStyleFrame
    {
        return $this->nextElement();
    }
}
