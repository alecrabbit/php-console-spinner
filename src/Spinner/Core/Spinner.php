<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class Spinner extends ASubject implements ISpinner
{
    public function __construct(
        protected IWidgetComposite $rootWidget,
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

    public function add(IWidgetComposite $element): IWidgetContext
    {
        return $this->rootWidget->add($element);
    }

    public function remove(IWidgetComposite $element): void
    {
        $this->rootWidget->remove($element);
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->rootWidget) {
            $this->notify();
        }
    }

}
