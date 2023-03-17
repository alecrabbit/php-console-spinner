<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

abstract class ASpinnerConfig implements ISpinnerConfig
{
    public function __construct(
        protected IWidgetComposite $rootWidget,
        protected bool $createInitialized,
        protected iterable $widgets,
    ) {
    }

    public function createInitialized(): bool
    {
        return $this->createInitialized;
    }

    /**
     * @inheritDoc
     */
    public function getWidgets(): iterable
    {
        return $this->widgets;
    }

    public function getRootWidget(): IWidgetComposite
    {
        return $this->rootWidget;
    }
}