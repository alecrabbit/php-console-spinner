<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Adapter\React;

use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

final class ReactLoop implements ILoop, ILoopProbe
{
    public function __construct(
        private readonly LoopInterface $loop,
    ) {
    }

    public function addPeriodicTimer(int|float $interval, callable $callback): void
    {
        $this->loop->addPeriodicTimer($interval, $callback);
    }

    public function addTimer(int|float $interval, callable $callback): void
    {
        $this->loop->addTimer($interval, $callback);
    }

    public function addSignal(int $signal, callable $callback): void
    {
        $this->loop->addSignal($signal, $callback);
    }

    public function removeSignal(int $signal, callable $callback): void
    {
        $this->loop->removeSignal($signal, $callback);
    }

    public function stop(): void
    {
        $this->loop->stop();
    }

    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    public static function getLoop(): ILoop
    {
        return new self(Loop::get());
    }
}
