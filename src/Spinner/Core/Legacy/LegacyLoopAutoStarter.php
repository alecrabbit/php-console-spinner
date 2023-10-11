<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;

/**
 * @deprecated
 */
final class LegacyLoopAutoStarter implements ILegacyLoopAutoStarter
{
    public function __construct(
        protected ILegacyLoopSettings $settings,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        if ($this->settings->isLoopAvailable() && $this->settings->isAutoStartEnabled()) {
            $loop->autoStart();
        }
    }
}
