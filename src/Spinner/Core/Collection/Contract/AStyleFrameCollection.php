<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class AStyleFrameCollection extends ACollection implements IStyleFrameCollection
{
    protected const ELEMENT_CLASS = IStyleFrame::class;
    /**
     * @param iterable<IStyleFrame> $frames
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct(iterable $frames)
    {
        foreach ($frames as $frame) {
            $this->addElement($frame);
        }
        $this->assertIsNotEmpty();
    }

    public function next(): IStyleFrame
    {
        return $this->nextElement();
    }
}
