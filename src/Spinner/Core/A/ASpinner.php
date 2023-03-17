<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use Closure;

abstract class ASpinner implements ISpinner
{
    protected bool $active = false;
    protected bool $interrupted = false;
    protected IFrame $currentFrame;
    protected int $framesWidthDiff = 0;

    public function __construct(
        protected readonly IDriver $driver,
        protected readonly ITimer $timer,
        protected IWidgetComposite $widget,
    ) {
        $this->currentFrame = FrameFactory::createEmpty();
    }

    public function initialize(): void
    {
        $this->driver->hideCursor();
        $this->activate();
        $this->update();
    }

    public function activate(): void
    {
        $this->active = true;
    }

    protected function update(float $dt = null): void
    {
        $previousFrame = $this->currentFrame;
        $this->currentFrame = $this->widget->update($dt);
        $this->framesWidthDiff =
            max(
                $previousFrame->width() - $this->currentFrame->width(),
                0
            );
    }

    public function interrupt(string $interruptMessage = null): void
    {
        $this->interrupted = true;
        $this->stop();
        $this->driver->interrupt($interruptMessage);
    }

    protected function stop(): void
    {
        $this->deactivate();
        $this->driver->showCursor();
    }

    public function deactivate(): void
    {
        $this->erase();
        $this->active = false;
    }

    public function erase(): void
    {
        if ($this->active) {
            $this->driver->erase($this->currentFrame);
        }
    }

    public function finalize(string $finalMessage = null): void
    {
        if ($this->interrupted) {
            return;
        }
        $this->stop();
        $this->driver->finalize($finalMessage);
    }

    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        $this->wrap(
            function () use ($element, &$result): void {
                $result = $this->widget->add($element);
            }
        );
        return $result;
    }

    public function wrap(Closure $closure, mixed ...$args): void
    {
        $this->erase();
        $closure(...$args);
        $this->spin();
    }

    public function spin(float $dt = null): void
    {
        $this->render(
            $dt ?? $this->elapsedTime()
        );
    }

    public function render(float $dt = null): void
    {
        if ($this->active) {
            $this->update($dt);
            $this->driver->display($this->currentFrame, $this->framesWidthDiff);
        }
    }

    protected function elapsedTime(): float
    {
        return $this->timer->elapsed();
    }

    public function remove(IWidgetComposite|IWidgetContext $element): void
    {
        $this->wrap(
            function () use ($element) {
                $this->widget->remove($element);
            }
        );
    }

    public function getInterval(): IInterval
    {
        return $this->widget->getInterval();
    }
}
