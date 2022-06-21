<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;

abstract class ACharFrameCollection extends ACollection implements ICharFrameCollection
{
    protected static function getElementClass(): string
    {
        return ICharFrame::class;
    }

    public function next(): ICharFrame
    {
        return $this->nextElement();
    }
}
