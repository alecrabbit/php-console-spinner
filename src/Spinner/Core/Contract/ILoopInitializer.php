<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;

interface ILoopInitializer
{
    public function initialize(): void;

    public function useConfig(ILoopConfig $config): ILoopInitializer;
}
