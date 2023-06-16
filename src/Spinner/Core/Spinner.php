<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\WidgetNotAComposite;

final class Spinner extends ASubject implements ISpinner
{
    public function __construct(
        protected IWidget $rootWidget,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->rootWidget->attach($this);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->rootWidget->getFrame($dt);
    }

    public function getInterval(): IInterval
    {
        return $this->rootWidget->getInterval();
    }

    public function add(IWidget $element): IWidgetContext
    {
        if ($this->rootWidget->isComposite()) {
            return $this->rootWidget->add($element);
        }
        throw new WidgetNotAComposite('Root widget is not a composite.');
    }

    public function remove(IWidget $element): void
    {
        if ($this->rootWidget->isComposite()) {
            $this->rootWidget->remove($element);
        }
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->rootWidget) {
            $this->notify();
        }
    }

}
