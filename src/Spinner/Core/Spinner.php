<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class Spinner implements ISpinner
{
    public function __construct(
        protected IWidget $rootWidget,
    ) {
    }

    public function update(?float $dt = null): IFrame
    {
        return $this->rootWidget->getFrame($dt);
    }

    public function getInterval(): IInterval
    {
        return $this->rootWidget->getInterval();
    }

    public function add(IWidget $element): IWidgetContext
    {
        return $this->rootWidget->add($element);
    }

    public function remove(IWidget $element): void
    {
        $this->rootWidget->remove($element);
    }
}
