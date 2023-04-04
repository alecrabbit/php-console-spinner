<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Override;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\A\ALoopAdapter;
use Closure;

final class ALoopAdapterOverride extends ALoopAdapter
{

    public function stop(): void
    {
        // TODO: Implement stop() method.
    }

    public function repeat(float $interval, Closure $closure): mixed
    {
        // TODO: Implement repeat() method.
    }

    public function run(): void
    {
        // TODO: Implement run() method.
    }

    public function delay(float $delay, Closure $closure): void
    {
        // TODO: Implement delay() method.
    }

    public function autoStart(): void
    {
        // TODO: Implement autoStart() method.
    }

    public function getEventLoop()
    {
        // TODO: Implement getLoop() method.
    }

    protected function onSignal(int $signal, Closure $closure): void
    {
        // TODO: Implement onSignal() method.
    }

    public function cancel(mixed $timer): void
    {
        // TODO: Implement cancel() method.
    }
}
