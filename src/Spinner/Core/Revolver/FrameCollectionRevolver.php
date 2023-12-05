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
    /**
     * @throws InvalidArgument
     */
    public function __construct(
        protected IFrameCollection $frameCollection,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);
        $this->assertIsNotEmpty();
    }

    /**
     * @throws InvalidArgument
     */
    protected function assertIsNotEmpty(): void
    {
        // FIXME (2023-12-05 15:0) [Alec Rabbit]: unnecessary check (already checked in FrameCollection::__construct)
        if ($this->frameCollection->count() === 0) {
            throw new InvalidArgument('Frame collection is empty.');
        }
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
