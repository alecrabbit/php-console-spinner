<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;

abstract class AStyleFrameCollection extends ACollection implements IStyleFrameCollection
{
    protected static function getElementClass(): string
    {
        return IStyleFrame::class;
    }

    public function next(): IStyleFrame
    {
        return $this->nextElement();
    }
}
