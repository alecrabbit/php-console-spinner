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
    protected int $count = 0;
    protected int $offset = 0;

    /**
     * @throws InvalidArgument
     */
    public function __construct(
        protected IFrameCollection $frameCollection,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);
        $this->count = $this->frameCollection->count();
        $this->assertIsNotEmpty();
    }

    /**
     * @throws InvalidArgument
     */
    protected function assertIsNotEmpty(): void
    {
        if ($this->count === 0) {
            throw new InvalidArgument('Frame collection is empty.');
        }
    }

    protected function next(?float $dt = null): void
    {
        if ($this->count === 1 || ++$this->offset === $this->count) {
            $this->offset = 0;
        }
    }

    protected function current(): IFrame
    {
        return $this->frameCollection->get($this->offset);
    }
}
