<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Config\Contract;

use AlecRabbit\Spinner\Core\Contract\IConfigProvider;

interface IConfigProviderFactory
{
    public function create(): IConfigProvider;
}
