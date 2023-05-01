<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;

interface IDriverSettingsBuilder
{
    public function build(): IDriverSettings;
}
