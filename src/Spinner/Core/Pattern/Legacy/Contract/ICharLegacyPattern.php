<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\Contract;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use Traversable;

interface ICharLegacyPattern extends ILegacyPattern
{
    /**
     * @return Traversable<int, ICharFrame>
     */
    public function getEntries(): Traversable;
}
