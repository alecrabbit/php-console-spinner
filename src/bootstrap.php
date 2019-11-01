<?php

declare(strict_types=1);

namespace AlecRabbit;

if (!function_exists(__NAMESPACE__ . '\typeOf')) {
    /**
     * Returns the type of a variable.
     *
     * @param mixed $var
     * @return string
     */
    function typeOf($var): string
    {
        return \is_object($var) ? \get_class($var) : \gettype($var);
    }
}
