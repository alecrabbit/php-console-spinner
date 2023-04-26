<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use Closure;

abstract class ASpinner implements ISpinner
{
    protected bool $active = false;
    protected bool $interrupted = false;

    public function __construct(
        protected readonly IDriver $driver,
        protected IWidgetComposite $rootWidget,
    ) {
    }

    public function initialize(): void
    {
        $this->driver->initialize();
        $this->activate();
        $this->update();
    }

    public function activate(): void
    {
        $this->active = true;
    }

    protected function update(float $dt = null): void
    {
        $this->driver->setCurrentFrame($this->rootWidget->update($dt));
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
    }

    public function deactivate(): void
    {
        $this->erase();
        $this->active = false;
    }

    public function erase(): void
    {
        if ($this->active) {
            $this->driver->erase();
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
                $result = $this->rootWidget->add($element);
            }
        );
        /** @var IWidgetContext */
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
        $this->render($this->elapsed($dt));
    }

    public function render(float $dt = null): void
    {
        if ($this->active) {
            $this->update($dt);
            $this->driver->display();
        }
    }

    protected function elapsed(?float $dt): float
    {
        return $dt ?? $this->driver->elapsedTime();
    }

    public function remove(IWidgetComposite|IWidgetContext $element): void
    {
        $this->wrap(
            function () use ($element) {
                $this->rootWidget->remove($element);
            }
        );
    }

    public function getInterval(): IInterval
    {
        return $this->rootWidget->getInterval();
    }
}
