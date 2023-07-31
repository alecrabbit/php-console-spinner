<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;

interface IDriverSettings
{
    public function getInitializationOption(): InitializationOption;

    public function setLinkerOption(LinkerOption $linkerOption): void;

    public function setInitializationOption(InitializationOption $initializationOption): void;

    public function getLinkerOption(): LinkerOption;
}
