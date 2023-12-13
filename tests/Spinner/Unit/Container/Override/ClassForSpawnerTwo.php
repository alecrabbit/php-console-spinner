<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Override;

use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class ClassForSpawnerTwo
{
    public function __construct(public null|IWidgetFactory $widgetFactory = null)
    {
    }
}
