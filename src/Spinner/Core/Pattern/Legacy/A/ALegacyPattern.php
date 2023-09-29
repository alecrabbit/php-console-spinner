<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use Traversable;

abstract class ALegacyPattern implements ILegacyPattern
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
