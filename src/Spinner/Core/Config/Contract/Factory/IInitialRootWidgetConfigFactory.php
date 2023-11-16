<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;

interface IInitialRootWidgetConfigFactory extends IInitialWidgetConfigFactory
{
    public function create(): IRootWidgetConfig;
}
