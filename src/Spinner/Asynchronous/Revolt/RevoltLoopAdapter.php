<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Revolt;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Closure;
use Revolt\EventLoop;

/**
 * @codeCoverageIgnore
 */
final class RevoltLoopAdapter extends ALoopAdapter
{
    private static bool $stopped = false;

    public function __construct(
        private readonly EventLoop\Driver $loop,
    ) {
    }

    public function cancel(mixed $timer): void
    {
        if (!is_string($timer)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid timer type: %s, expected string',
                    gettype($timer)
                )
            );
        }
        EventLoop::cancel($timer);
    }

    public function repeat(float $interval, Closure $closure): string
    {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        return EventLoop::repeat($interval, $closure);
    }

    public function autoStart(): void
    {
        // Automatically run loop at the end of script, unless already started or stopped explicitly.
        // @codeCoverageIgnoreStart
        $hasRun = false;
        EventLoop::defer(static function () use (&$hasRun): void {
            $hasRun = true;
        });

        $stopped = &self::$stopped;
        register_shutdown_function(static function () use (&$hasRun, &$stopped): void {
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

    public function run(): void
    {
        $this->loop->run();
    }

    public function delay(float $delay, Closure $closure): void
    {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        EventLoop::delay($delay, $closure);
    }

    public function stop(): void
    {
        self::$stopped = true;
        $this->loop->stop();
    }

    public function onSignal(int $signal, Closure $closure): void
    {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        EventLoop::onSignal($signal, $closure);
    }
}
