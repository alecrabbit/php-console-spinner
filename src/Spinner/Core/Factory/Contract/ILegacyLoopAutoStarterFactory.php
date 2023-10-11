<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;

/**
 * @deprecated
 */
interface ILegacyLoopAutoStarterFactory
{
    public function create(): ILegacyLoopAutoStarter;
}
