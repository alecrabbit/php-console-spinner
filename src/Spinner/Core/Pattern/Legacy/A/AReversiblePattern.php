<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\A;

use Traversable;

abstract class AReversiblePattern extends ALegacyPattern
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
