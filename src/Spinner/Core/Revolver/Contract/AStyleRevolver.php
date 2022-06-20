<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;

abstract class AStyleRevolver implements IStyleRevolver
{
    public function __construct(
        protected readonly IStyleFrameCollection $collection,
    ) {
    }

    public function next(): IStyleFrame
    {
        return $this->collection->next();
    }
}
