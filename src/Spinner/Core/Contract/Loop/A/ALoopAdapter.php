<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\A;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use Closure;

/**
 * @codeCoverageIgnore
 */
abstract class ALoopAdapter implements ILoop
{
    protected static function error(): bool
    {
        // will be `null` if error handler set by `set_error_handler()` successfully handled the error
        $error = error_get_last(); // [889ad594-ca28-4770-bb38-fd5bd8cb1777]

        return (bool)(($error['type'] ?? 0)
            &
            (E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR));
    }
}
