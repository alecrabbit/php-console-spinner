<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Core\Contract\IBaseSpinner;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;

abstract class AWBaseSpinner implements IBaseSpinner,
                                        WHasInterval
{
    protected bool $active;
    protected ?ICharFrame $currentFrame = null;
    protected readonly IDriver $driver;
    protected bool $interrupted = false;
    protected readonly string $finalMessage;
    protected readonly string $interruptMessage;

    public function __construct(IConfig $config)
    {
        $this->driver = $config->getDriver();
        $this->finalMessage = $config->getFinalMessage();
        $this->interruptMessage = $config->getInterruptMessage();
    }

    abstract public function getInterval(): IWInterval;

    public function initialize(): void
    {
        $this->driver->hideCursor();
        $this->start();
    }

    private function start(): void
    {
        $this->active = true;
    }

    public function resume(): void
    {
        $this->active = true;
    }


    public function wrap(callable $callback, ...$args): void
    {
        $this->erase();
        $callback(...$args);
        $this->spin();
    }

    public function erase(): void
    {
        $this->driver->erase(
            $this->currentFrame?->getWidth() ?? 1
        );
    }

    public function spin(): void
    {
        if ($this->active) {
            $this->render();
            $this->driver->writeFrame($this->currentFrame);
        }
    }

    private function render(): void
    {
        $this->currentFrame = $this->wigglers->render();
    }

    public function interrupt(): void
    {
        $this->interrupted = true;
        $this->stop();
        $this->driver->message(PHP_EOL . $this->interruptMessage);
    }

    private function stop(): void
    {
        $this->pause();
        $this->driver->showCursor();
    }

    public function pause(): void
    {
        $this->erase();
        $this->active = false;
    }

    public function finalize(): void
    {
        if (!$this->interrupted) {
            $this->stop();
            $this->driver->message($this->finalMessage);
        }
    }
}
