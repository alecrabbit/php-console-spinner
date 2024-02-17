<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

abstract class AWidget extends ASubject implements IWidget
{
    public function __construct(
        protected readonly IWidgetRevolver $widgetRevolver,
        protected readonly ISequenceFrame $leadingSpacer,
        protected readonly ISequenceFrame $trailingSpacer,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
    }

    public function getInterval(): IInterval
    {
        return $this->widgetRevolver->getInterval();
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
    {
        $widgetRevolverFrame = $this->widgetRevolver->getFrame($dt);

        return $this->createFrame(
            $this->leadingSpacer->getSequence()
            . $widgetRevolverFrame->getSequence()
            . $this->trailingSpacer->getSequence(),
            $this->leadingSpacer->getWidth()
            + $widgetRevolverFrame->getWidth()
            + $this->trailingSpacer->getWidth()
        );
    }

    protected function createFrame(string $sequence, int $width): ICharSequenceFrame
    {
        return new CharFrame($sequence, $width);
    }
}
