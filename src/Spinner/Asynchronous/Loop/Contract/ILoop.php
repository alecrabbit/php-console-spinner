<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Closure;
use React\EventLoop\LoopInterface;
use Revolt\EventLoop\Driver;

interface ILoop
{
    public function getLoop(): LoopInterface|Driver;

    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): void;

    public function delay(float $delay, Closure $closure): void;

    public function attach(ISpinner $spinner): void;

    public function setSignalHandlers(iterable $handlers): void;

    /**
     * @throws RuntimeException
     */
    public function createSignalHandlers(ISpinner $spinner): iterable;

    public function autoStart(): void; // TODO: choose a better name
}
