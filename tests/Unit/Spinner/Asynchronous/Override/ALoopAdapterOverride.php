<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use Closure;
use RuntimeException;

final class ALoopAdapterOverride extends ALoopAdapter
{
    public function stop(): void
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }

    public function repeat(float $interval, Closure $closure): mixed
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }

    public function run(): void
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }

    public function delay(float $delay, Closure $closure): void
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }

    public function autoStart(): void
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }

    public function onSignal(int $signal, Closure $closure): void
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }

    public function cancel(mixed $timer): void
    {
        throw new RuntimeException('Method SHOULD NOT be called.');
    }
}
