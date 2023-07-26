<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use Traversable;

abstract class APattern implements IPattern
{
    public function __construct(
        protected ?Traversable $entries = null,
        protected ?int $interval = null,
    ) {
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function isReversed(): bool
    {
        return false;
    }
}
