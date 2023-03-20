<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class AFrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver
{
    protected int $count = 0;
    protected int $offset = 0;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected IFrameCollection $frames,
        IInterval $interval,
    ) {
        parent::__construct($interval);
        $this->count = $this->frames->count();
        $this->assertIsNotEmpty();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertIsNotEmpty(): void
    {
        if (0 === $this->count) {
            throw new InvalidArgumentException(
                sprintf('%s: Frame collection is empty.', static::class)
            );
        }
    }

    protected function next(float $dt = null): void
    {
        if (1 === $this->count || ++$this->offset === $this->count) {
            $this->offset = 0;
        }
    }

    protected function current(): IFrame
    {
        return $this->frames->get($this->offset);
    }
}
