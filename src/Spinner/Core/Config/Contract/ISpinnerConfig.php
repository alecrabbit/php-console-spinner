<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

interface ISpinnerConfig
{
    public function createInitialized(): bool;

    /**
     * @return IWidgetComposite[]
     */
    public function getWidgets(): iterable;

    public function getRootWidget(): IWidgetComposite;
}