<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyLoopSettings;

interface ILoopAutoStarterBuilder
{
    public function build(): ILoopAutoStarter;

    public function withSettings(ILegacyLoopSettings $settings): ILoopAutoStarterBuilder;
}
