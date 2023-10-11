<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;

/**
 * @deprecated Will be removed
 */
interface ILegacySignalHandlersSetupBuilder
{
    public function build(): ILegacySignalHandlersSetup;

    public function withLoopSettings(ILegacyLoopSettings $settings): ILegacySignalHandlersSetupBuilder;

    public function withLoop(ILoop $loop): ILegacySignalHandlersSetupBuilder;

    public function withDriverSettings(ILegacyDriverSettings $settings): ILegacySignalHandlersSetupBuilder;
}
