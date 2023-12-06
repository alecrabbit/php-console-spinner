<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final class FrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver
{
    public function __construct(
        protected IFrameCollection $frameCollection,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);
    }

    protected function next(?float $dt = null): void
    {
        $this->frameCollection->next();
    }

    protected function current(): IFrame
    {
        return $this->frameCollection->current();
    }
}
