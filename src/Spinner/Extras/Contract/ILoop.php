<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Closure;
use React\EventLoop\LoopInterface;
use Revolt\EventLoop\Driver;

/**
 * TODO: Segregate interface for responsibilities of Loop class.
 *  e.g.:
 *   ILoopSpinnerAttach
 *   ILoopGetter
 *   ILoopSignalHandlers
 */
interface ILoop
{
    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): void;

    public function delay(float $delay, Closure $closure): void;

    public function autoStart(): void; // TODO: choose a better name

    public function attach(ISpinner $spinner): void;

    public function getLoop(): LoopInterface|Driver;

    public function setSignalHandlers(iterable $handlers): void;

    /**
     * @throws RuntimeException
     */
    public function createSignalHandlers(ISpinner $spinner): iterable;
}
