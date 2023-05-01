<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;

interface IDefaultsProviderBuilder
{
    public function build(): IDefaultsProvider;
}
