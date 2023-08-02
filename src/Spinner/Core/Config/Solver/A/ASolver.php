<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\A;

use AlecRabbit\Spinner\Core\Config\Contract\Solver\ISolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

abstract class ASolver implements ISolver
{
    public function __construct(
        protected ISettingsProvider $settingsProvider,
    ) {
    }

    abstract public function solve(): mixed;
}
