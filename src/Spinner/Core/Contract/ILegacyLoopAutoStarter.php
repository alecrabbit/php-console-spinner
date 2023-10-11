<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;

/**
 * @deprecated
 */
interface ILegacyLoopAutoStarter
{
    public function setup(ILoop $loop): void;
}
