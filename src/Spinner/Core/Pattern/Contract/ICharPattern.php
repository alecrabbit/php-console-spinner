<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use Traversable;

interface ICharPattern extends IPattern
{
    /**
     * @return Traversable<int, ICharFrame>
     */
    public function getEntries(): Traversable;
}
