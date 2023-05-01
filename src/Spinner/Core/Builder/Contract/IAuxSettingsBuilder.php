<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;

interface IAuxSettingsBuilder
{
    public function build(): IAuxSettings;
}
