<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use Traversable;

abstract class ASpinnerConfig
{
    public function __construct(
        protected IWidgetComposite $rootWidget,
        protected OptionInitialization $initialization,
        protected Traversable $widgets,
    ) {
    }

    public function isEnabledInitialization(): bool
    {
        return $this->initialization === OptionInitialization::ENABLED;
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