<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class AWidget extends ASubject implements IWidget
{
    protected IWidgetContext $context;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        ?IWidgetContext $context = null,
    ) {
        $this->context = $this->refineContext($context);
        parent::__construct($context);
    }

    protected function refineContext(?IWidgetContext $context): IWidgetContext
    {
        if ($context === null) {
            return new WidgetContext($this);
        }
        $context->replaceWidget($this);
        return $context;
    }

    public function getInterval(): IInterval
    {
        return $this->revolver->getInterval();
    }

    public function replaceContext(IWidgetContext $context): void
    {
        if ($context->getWidget() !== $this) {
            throw new InvalidArgumentException(
                sprintf(
                    'Context is not related to this widget.'
                    . ' Call `%s` first.',
                    IWidgetContext::class . '::replaceWidget()'
                )
            );
        }
        $this->context = $context;
    }

    public function getContext(): IWidgetContext
    {
        return $this->context;
    }
}
