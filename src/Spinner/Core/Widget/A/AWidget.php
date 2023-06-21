<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class AWidget extends ASubject implements IWidget
{
    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        protected ?IObserver $observer = null,
    ) {
        parent::__construct($observer); // Context is the observer
    }

    protected function adoptContext(?IWidgetContext $context): ?IWidgetContext
    {
        if ($context instanceof IWidgetContext) {
            $context->adoptWidget($this);
            $this->notify();
        }
        return $context;
    }

    public function getInterval(): IInterval
    {
        return $this->revolver->getInterval();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $revolverFrame = $this->revolver->getFrame($dt);

        return
            new CharFrame(
                $this->leadingSpacer->sequence() . $revolverFrame->sequence() . $this->trailingSpacer->sequence(),
                $this->leadingSpacer->width() + $revolverFrame->width() + $this->trailingSpacer->width()
            );
    }
}
