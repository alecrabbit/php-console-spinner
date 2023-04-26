<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use SplObserver;
use SplSubject;

final class Spinner implements ISpinner
{
    public function __construct(
        protected IWidget $rootWidget,
        protected ?IObserver $observer = null,
    ) {
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
        return $this->rootWidget->add($element);
    }

    public function remove(IWidget $element): void
    {
        $this->rootWidget->remove($element);
    }

    public function attach(SplObserver $observer): void
    {
        if ($this->observer !== null) {
            throw new InvalidArgumentException('Observer is already attached.');
        }

        $this->assertNotSelf($observer);

        $this->observer = $observer;
    }

    protected function assertNotSelf(object $obj): void
    {
        if ($obj === $this) {
            throw new InvalidArgumentException('Object can not be self.');
        }
    }

    public function update(SplSubject $subject): void
    {
        if ($subject === $this->rootWidget) {
            $this->notify();
        }
    }

    public function notify(): void
    {
        $this->observer?->update($this);
    }

    public function detach(SplObserver $observer): void
    {
        if ($this->observer === $observer) {
            $this->observer = null;
        }
    }
}
