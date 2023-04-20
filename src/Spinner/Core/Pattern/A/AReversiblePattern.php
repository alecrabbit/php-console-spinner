<?php

declare(strict_types=1);

// 10.03.23

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use ArrayObject;
use Traversable;

abstract class AReversiblePattern extends APattern
{
    public function __construct(
        ?Traversable $entries = null,
        ?int $interval = null,
        protected bool $reversed = false,
    ) {
        parent::__construct($entries, $interval);
    }

    public function isReversed(): bool
    {
        return $this->reversed;
    }
}
