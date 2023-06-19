<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
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
        protected ?IWidgetContext $context = null,
    ) {
        parent::__construct($context); // Context is the observer
        $this->context = $this->adoptContext($context);
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

    public function envelopWithContext(IWidgetContext $context): void
    {
        if ($context->getWidget() !== $this) {
            throw new InvalidArgumentException(
                'Context is not related to this widget.'

            );
        }

        if ($this->context !== $context) {
            $this->context = $context;
            $this->notify();
        }
    }

    public function getContext(): IWidgetContext
    {
        return $this->context;
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
