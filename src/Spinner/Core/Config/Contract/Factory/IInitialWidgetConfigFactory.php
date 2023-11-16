<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

interface IInitialWidgetConfigFactory
{
    public function create(): IWidgetConfig;
}
