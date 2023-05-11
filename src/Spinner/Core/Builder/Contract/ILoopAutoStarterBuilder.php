<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

interface ILoopAutoStarterBuilder
{
    public function build(): ILoopAutoStarter;

    public function withSettings(ILoopSettings $settings): ILoopAutoStarterBuilder;

    public function withLoop(ILoop $loop): ILoopAutoStarterBuilder;
}
