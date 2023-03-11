<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop\Adapter;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;
use React\EventLoop\LoopInterface;
use Revolt\EventLoop;
use Revolt\EventLoop\Driver;
use Revolt\EventLoop\Driver\EvDriver;
use Revolt\EventLoop\Driver\EventDriver;
use Revolt\EventLoop\Driver\UvDriver;

class RevoltLoopAdapter extends ALoopAdapter
{
    private static bool $stopped = false;
    private ?string $spinnerTimer = null;

    public function attach(ISpinner $spinner): void
    {
        $this->detachPrevious();
        $this->spinnerTimer = EventLoop::repeat(
            $spinner->getInterval()->toSeconds(),
            static fn() => $spinner->spin()
        );
    }

    private function detachPrevious(): void
    {
        if ($this->spinnerTimer) {
            EventLoop::cancel($this->spinnerTimer);
        }
    }

    public function repeat(float $interval, Closure $closure): void
    {
        EventLoop::repeat($interval, $closure);
    }

    public function autoStart(): void
    {
        // Automatically run loop at end of program, unless already started or stopped explicitly.
        // @codeCoverageIgnoreStart
        $hasRun = false;
        EventLoop::defer(static function () use (&$hasRun): void {
            $hasRun = true;
        });

        $stopped =& self::$stopped;
        register_shutdown_function(static function () use (&$hasRun, &$stopped) {
            // Don't run if we're coming from a fatal error (uncaught exception).
            if (self::error()) {
                return;
            }

            if (!$hasRun && !$stopped) {
                EventLoop::run();
            }
        });
        // @codeCoverageIgnoreEnd
    }

    public function delay(float $delay, Closure $closure): void
    {
        EventLoop::delay($delay, $closure);
    }

    protected function assertExtPcntl(): void
    {
        $driver = $this->getLoop();
        if ($driver instanceof UvDriver
            || $driver instanceof EvDriver
            || $driver instanceof EventDriver) {
            return; // these drivers do not require pcntl extension
        }

        parent::assertExtPcntl();
    }

    public function getLoop(): LoopInterface|Driver
    {
        return EventLoop::getDriver();
    }

    protected function onSignal(int $signal, Closure $closure): void
    {
        EventLoop::onSignal($signal, $closure);
    }
}
