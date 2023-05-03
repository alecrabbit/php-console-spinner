<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\ICharPattern;
use Traversable;

abstract class ACharPattern extends AReversiblePattern implements ICharPattern
{
    /** @inheritdoc */
    public function getEntries(): Traversable
    {
        return $this->entries;
    }

}
