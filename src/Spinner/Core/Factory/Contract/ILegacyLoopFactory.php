<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;

/**
 * @deprecated
 */
interface ILegacyLoopFactory
{
    public function getLoop(): ILoop;
}
