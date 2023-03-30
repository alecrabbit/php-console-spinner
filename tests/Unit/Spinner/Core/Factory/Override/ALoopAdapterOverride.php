<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\Override;

use AlecRabbit\Spinner\Core\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;

final class ALoopAdapterOverride extends ALoopAdapter
{

    public function stop(): void
    {
        // TODO: Implement stop() method.
    }

    public function repeat(float $interval, Closure $closure): void
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

    public function getLoop()
    {
        // TODO: Implement getLoop() method.
    }

    public function attach(ISpinner $spinner): void
    {
        // TODO: Implement attach() method.
    }

    protected function onSignal(int $signal, Closure $closure): void
    {
        // TODO: Implement onSignal() method.
    }

    protected function detachSpinner(): void
    {
        // TODO: Implement detachSpinner() method.
    }
}
