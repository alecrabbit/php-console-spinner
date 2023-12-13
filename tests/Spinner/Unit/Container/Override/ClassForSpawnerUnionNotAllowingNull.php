<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Override;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class ClassForSpawnerUnionNotAllowingNull
{
    public function __construct(public null|IWidgetSettings|IWidgetConfig $param)
    {
    }
}
