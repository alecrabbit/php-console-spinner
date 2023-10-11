<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;

/**
 * @deprecated
 */
interface ILegacyLoopAutoStarterBuilder
{
    public function build(): ILegacyLoopAutoStarter;

    public function withSettings(ILegacyLoopSettings $settings): ILegacyLoopAutoStarterBuilder;
}
