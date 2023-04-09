<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\ILegacyDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use Closure;

abstract class ALegacySpinner implements ILegacySpinner
{
    protected bool $active = false;
    protected bool $interrupted = false;

    public function __construct(
        protected readonly ILegacyDriver $driver,
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
        if ($this->active) {
            $this->interrupted = true;
            $this->stop();
            $this->driver->interrupt($interruptMessage);
        }
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
        if ($this->active) {
            $this->stop();
            $this->driver->finalize($finalMessage);
        }
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

    /**
     * Wraps/decorates $closure with spinner erase() and spin() methods.
     */
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
