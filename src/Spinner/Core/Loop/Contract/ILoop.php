<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Exception\RuntimeException;
use React\EventLoop\LoopInterface;
use Revolt\EventLoop;
use Revolt\EventLoop\Driver;

interface ILoop
{
    public function attach(ISpinner $spinner): void;

    public function repeat(float $interval, callable $callback): void;

    public function delay(float $delay, callable $callback): void;

    public function getUnderlyingLoop(): LoopInterface|Driver;

    public function stop(): void;

    public function setSignalHandlers(iterable $handlers): void;

    /**
     * @throws RuntimeException
     */
    public function createSignalHandlers(ISpinner $spinner): iterable;

    public function autoStart(): void;
}
