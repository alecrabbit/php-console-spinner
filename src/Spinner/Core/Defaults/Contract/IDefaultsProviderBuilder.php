<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;

interface IDefaultsProviderBuilder
{
    public function build(): IDefaultsProvider;
}
