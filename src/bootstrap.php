<?php declare(strict_types=1);

namespace AlecRabbit;

if (!function_exists(__NAMESPACE__ . '\typeOf')) {

    define(__NAMESPACE__ . '\STR_DOUBLE', 'double');
    define(__NAMESPACE__ . '\STR_FLOAT', 'float');

    define(__NAMESPACE__ . '\STR_DOUBLE_LENGTH', strlen(STR_DOUBLE));

    /**
     * Returns the type of a variable.
     *
     * @param mixed $var
     * @return string
     */
    function typeOf($var): string
    {
        $type = \is_object($var) ? \get_class($var) : \gettype($var);
        if (strlen($type) === STR_DOUBLE_LENGTH) {
            $type = str_replace(STR_DOUBLE, STR_FLOAT, $type);
        }
        return $type;
    }
}