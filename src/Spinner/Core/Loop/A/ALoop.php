<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\A;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use Closure;

/**
 * @codeCoverageIgnore
 */
abstract class ALoop implements ILoop
{
    protected static function error(): bool
    {
        // will be `null` if error handler set by `set_error_handler()` successfully handled the error
        $error = error_get_last(); // [889ad594-ca28-4770-bb38-fd5bd8cb1777]

        return
            (bool)(
                ($error['type'] ?? 0)
                &
                (E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR)
            );
    }

    abstract public function onSignal(int $signal, Closure $closure): void;

    abstract public function stop(): void;

    abstract public function repeat(float $interval, Closure $closure): mixed;

    abstract public function run(): void;

    abstract public function cancel(mixed $timer): void;
}
