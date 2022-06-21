<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContainer;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\IDriver;

abstract class ABaseSpinner implements IBaseSpinner
{
    protected bool $active = false;
    protected bool $interrupted = false;
    protected int $currentWidth = 0;
    protected readonly string $finalMessage;
    protected readonly string $interruptMessage;
    protected readonly IDriver $driver;
    protected readonly ITwirlerContainer $container; // TODO (2022-06-20 15:19) [Alec Rabbit]: refine type.

    public function __construct(IConfig $config)
    {
        $this->driver = $config->getDriver();
        $this->finalMessage = $config->getFinalMessage();
        $this->interruptMessage = $config->getInterruptMessage();
        $this->container = $config->getContainer();
    }

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
        $this->driver->erase($this->currentWidth);
    }

    public function spin(): void
    {
        if ($this->active) {
            // FIXME (2022-06-21 12:29) [Alec Rabbit]: weak point.
            $this->currentWidth =
                $this->driver->display(
                    $this->container->render()
                );
            // TODO (2022-06-21 12:31) [Alec Rabbit]:
            //  should be something like:
            //  $frame = $this->container->render()
            //  $this->currentWidth = $frame->getWidth();
            //  $this->driver->display($frame);
        }
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
