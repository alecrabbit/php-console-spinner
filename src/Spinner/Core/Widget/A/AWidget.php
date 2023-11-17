<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

abstract class AWidget extends ASubject implements IWidget
{
    public function __construct(
        protected readonly IWidgetRevolver $widgetRevolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        protected ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
    }

    public function getInterval(): IInterval
    {
        return $this->widgetRevolver->getInterval();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $widgetRevolverFrame = $this->widgetRevolver->getFrame($dt);

        return new CharFrame(
            $this->leadingSpacer->sequence() . $widgetRevolverFrame->sequence() . $this->trailingSpacer->sequence(),
            $this->leadingSpacer->width() + $widgetRevolverFrame->width() + $this->trailingSpacer->width()
        );
    }
}
