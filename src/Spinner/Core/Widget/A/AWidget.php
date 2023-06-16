<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class AWidget extends ASubject implements IWidget
{
    protected IInterval $interval;
    protected IWidgetContext $context;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $this->revolver->getInterval();
        $this->context = new WidgetContext($this);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function replaceContext(IWidgetContext $context): void
    {
        if ($context->getWidget() !== $this) {
            throw new InvalidArgumentException('Context is not related to this widget.');
        }
        $this->context = $context;
    }
    public function getContext(): IWidgetContext
    {
        return $this->context;
    }
}
