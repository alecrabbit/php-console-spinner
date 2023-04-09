<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

final class Spinner implements ISpinner
{
    protected bool $active = false;

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
}
