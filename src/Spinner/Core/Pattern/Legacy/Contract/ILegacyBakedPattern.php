<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
interface ILegacyBakedPattern
{
    public function getFrameCollection(): IFrameCollection;

    public function getInterval(): IInterval;
}
