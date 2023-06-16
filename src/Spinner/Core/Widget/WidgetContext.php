<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class WidgetContext extends ASubject implements IWidgetContext
{
    protected IWidget $widget;

    public function __construct(
        IWidget $widget,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->replaceWidget($widget);
    }

    public function replaceWidget(IWidget $widget): void
    {
        $this->widget = $widget;
        $widget->replaceContext($this);
    }

    public function getWidget(): IWidget
    {
        return $this->widget;
    }

    public function update(ISubject $subject): void
    {
        // TODO: Implement update() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function attach(IObserver $observer): void
    {
        // TODO: Implement attach() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function detach(IObserver $observer): void
    {
        // TODO: Implement detach() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function notify(): void
    {
        // TODO: Implement notify() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function getInterval(): IInterval
    {
        // TODO: Implement getInterval() method.
        throw new \RuntimeException('Not implemented.');
    }
}
