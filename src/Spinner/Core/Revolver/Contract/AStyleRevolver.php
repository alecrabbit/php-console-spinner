<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

abstract class AStyleRevolver extends ARevolver implements IStyleRevolver
{
    public function __construct(
        protected readonly IStyleFrameCollection $collection,
    ) {
        parent::__construct($collection->getInterval());
    }

    public function next(): IStyleFrame
    {
        return $this->collection->next();
    }
}
