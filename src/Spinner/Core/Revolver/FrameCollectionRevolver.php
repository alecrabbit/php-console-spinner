<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class FrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver
{
    protected int $count = 0;
    protected int $offset = 0;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected IFrameCollection $frameCollection,
        IInterval $interval,
    ) {
        parent::__construct($interval);
        $this->count = $this->frameCollection->count();
        $this->assertIsNotEmpty();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertIsNotEmpty(): void
    {
        if ($this->count === 0) {
            throw new InvalidArgumentException('Frame collection is empty.');
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
