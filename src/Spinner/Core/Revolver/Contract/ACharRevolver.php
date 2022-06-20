<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;

abstract class ACharRevolver implements ICharRevolver
{
    public function __construct(
        protected readonly ICharFrameCollection $collection,
    ) {
    }

    public function next(): ICharFrame
    {
        return $this->collection->next();
    }

}
