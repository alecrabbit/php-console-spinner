<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use Traversable;

interface ISpinnerConfig
{
    public function isInitializationEnabled(): bool;

    public function getWidgets(): Traversable;

    public function getRootWidget(): IWidgetComposite;
}