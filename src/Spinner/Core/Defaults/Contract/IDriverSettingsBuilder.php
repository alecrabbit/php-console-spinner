<?php

declare(strict_types=1);

// 05.04.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface IDriverSettingsBuilder
{
    public function build(): IDriverSettings;
}
