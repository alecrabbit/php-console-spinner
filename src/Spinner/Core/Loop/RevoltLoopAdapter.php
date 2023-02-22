<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Helper\Asserter;
use Revolt\EventLoop;
use Revolt\EventLoop\Driver\EvDriver;
use Revolt\EventLoop\Driver\EventDriver;
use Revolt\EventLoop\Driver\UvDriver;

final class RevoltLoopAdapter extends ALoopAdapter
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

    protected function doCreateHandlers(ISpinner $spinner): iterable
    {
        yield from [
            SIGINT => static function () use ($spinner): never {
                $spinner->interrupt();
                exit();
            },
        ];
    }

    protected function assertDependencies(): void
    {
        $driver = EventLoop::getDriver();
        if ($driver instanceof UvDriver
            || $driver instanceof EvDriver
            || $driver instanceof EventDriver) {
            return; // these drivers do not require pcntl extension
        }

        Asserter::assertExtensionLoaded('pcntl', 'Signal handling requires the pcntl extension.');
    }

    protected function onSignal(int $signal, callable $handler): void
    {
        EventLoop::onSignal($signal, $handler);
    }
}
