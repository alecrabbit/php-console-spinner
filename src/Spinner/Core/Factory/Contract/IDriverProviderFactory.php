<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriverProvider;

interface IDriverProviderFactory
{
    public function create(): IDriverProvider;
}
