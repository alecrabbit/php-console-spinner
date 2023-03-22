<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\Initialization;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use Traversable;

abstract class ASpinnerConfig implements ISpinnerConfig
{
    public function __construct(
        protected IWidgetComposite $rootWidget,
        protected Initialization $initialization,
        protected Traversable $widgets,
    ) {
    }

    public function isInitializationEnabled(): bool
    {
        return $this->initialization === Initialization::ENABLED;
    }

    public function getWidgets(): Traversable
    {
        return $this->widgets;
    }

    public function getRootWidget(): IWidgetComposite
    {
        return $this->rootWidget;
    }
}