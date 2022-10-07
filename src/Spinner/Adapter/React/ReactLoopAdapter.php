<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Adapter\React;

use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

final class ReactLoopAdapter implements ILoop, ILoopProbe
{
    private static ?self $instance = null;

    private function __construct(
        private readonly LoopInterface $loop,
    ) {
    }

    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    public static function getLoop(): ILoop
    {
        if (self::$instance) {
            return self::$instance;
        }
        return
            self::$instance = new self(Loop::get());
    }

    public static function getPackageName(): string
    {
        return 'react/event-loop';
    }

    public function periodic(int|float $interval, callable $callback): void
    {
        $this->loop->addPeriodicTimer($interval, $callback);
    }

    public function defer(int|float $interval, callable $callback): void
    {
        $this->loop->addTimer($interval, $callback);
    }

    public function addHandler(int $signal, callable $callback): void
    {
        $this->loop->addSignal($signal, $callback);
    }

    public function removeHandler(int $signal, callable $callback): void
    {
        $this->loop->removeSignal($signal, $callback);
    }

    public function stop(): void
    {
        $this->loop->stop();
    }
}
