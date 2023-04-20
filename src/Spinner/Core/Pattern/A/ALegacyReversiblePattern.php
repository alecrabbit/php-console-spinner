<?php

declare(strict_types=1);

// 10.03.23

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use ArrayObject;
use Traversable;

abstract class ALegacyReversiblePattern extends APattern
{
    public function __construct(
        ?IInterval $interval = null,
        protected bool $reversed = false
    ) {
        parent::__construct($interval);
    }

    public function getEntries(): Traversable
    {
        return $this->reversed
            ? $this->reversedEntries()
            : $this->entries();
    }

    protected function reversedEntries(): Traversable
    {
        return new ArrayObject(
            array_reverse(
                iterator_to_array($this->entries())
            )
        );
    }
}
