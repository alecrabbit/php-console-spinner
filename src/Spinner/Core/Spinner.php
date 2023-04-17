<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class Spinner implements ISpinner
{
    public function __construct(
        protected IWidgetComposite $rootWidget,
    ) {
    }

    public function update(?float $dt = null): IFrame
    {
        return $this->rootWidget->update($dt);
    }

    public function getInterval(): IInterval
    {
        return $this->rootWidget->getInterval();
    }

    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        return $this->rootWidget->add($element);
    }

    public function remove(IWidgetComposite|IWidgetContext $element): void
    {
        $this->rootWidget->remove($element);
    }
}
