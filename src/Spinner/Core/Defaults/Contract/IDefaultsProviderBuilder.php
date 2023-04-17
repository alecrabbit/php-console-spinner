<?php

declare(strict_types=1);

// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;

interface IDefaultsProviderBuilder
{
    public function build(): IDefaultsProvider;
}
