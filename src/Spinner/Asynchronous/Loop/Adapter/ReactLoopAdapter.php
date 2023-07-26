<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop\Adapter;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Closure;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;

/**
 * @codeCoverageIgnore
 */
final class ReactLoopAdapter extends ALoopAdapter
{
    public function __construct(
        private readonly LoopInterface $reactLoop,
    ) {
    }

    public function autoStart(): void
    {
        // ReactPHP event loop is started by its library code.
    }

    public function repeat(float $interval, Closure $closure): TimerInterface
    {
        return $this->reactLoop->addPeriodicTimer($interval, $closure);
    }

    public function delay(float $delay, Closure $closure): void
    {
        $this->reactLoop->addTimer($delay, $closure);
    }

    public function run(): void
    {
        $this->reactLoop->run();
    }

    public function stop(): void
    {
        $this->reactLoop->stop();
    }

    public function cancel(mixed $timer): void
    {
        if (!$timer instanceof TimerInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid timer type: %s, expected %s',
                    gettype($timer),
                    TimerInterface::class
                )
            );
        }
        $this->reactLoop->cancelTimer($timer);
    }

    public function onSignal(int $signal, Closure $closure): void
    {
        $this->reactLoop->addSignal($signal, $closure);
    }
}
