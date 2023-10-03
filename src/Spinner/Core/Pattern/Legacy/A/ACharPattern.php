<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ICharLegacyPattern;
use Traversable;

abstract class ACharPattern extends AReversiblePattern implements ICharLegacyPattern
{
    /** @inheritDoc */
    public function getEntries(): Traversable
    {
        return $this->entries;
    }

}
