<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetContext;

final class Spinner implements ISpinner
{
    public function __construct(
        protected ILegacyWidgetComposite $rootWidget,
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

    public function add(ILegacyWidgetComposite|ILegacyWidgetContext $element): ILegacyWidgetContext
    {
        return $this->rootWidget->add($element);
    }

    public function remove(ILegacyWidgetComposite|ILegacyWidgetContext $element): void
    {
        $this->rootWidget->remove($element);
    }
}
