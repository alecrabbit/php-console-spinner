<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;

interface ISpinnerInitializer
{
    public function initialize(ISpinner $spinner): void;

    public function useConfig(ISpinnerConfig $config): ISpinnerInitializer;

    public function useRunMode(OptionRunMode $runMode): ISpinnerInitializer;
}
