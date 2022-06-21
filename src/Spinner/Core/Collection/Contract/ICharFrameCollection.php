<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;

interface ICharFrameCollection extends ICollection
{
    public function next(): ICharFrame;
}
