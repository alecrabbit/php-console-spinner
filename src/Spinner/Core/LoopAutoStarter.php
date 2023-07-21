<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyLoopSettings;

final class LoopAutoStarter implements ILoopAutoStarter
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
