<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;

/**
 * @deprecated Will be removed
 */
interface ILegacySignalHandlersSetupFactory
{
    public function create(): ILegacySignalHandlersSetup;
}
