<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Helper;

final class Value
{

    public static function stringify(mixed $value, bool $unwrap = true): string
    {
        $type = gettype($value);
        if (!$unwrap) {
            return $type;
        }
        if (is_scalar($value)) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            return sprintf('%s(%s)', $type, $value);
        }
        if (is_object($value)) {
            return sprintf('%s(%s)', $type, get_class($value));
        }
        return $type;
    }
}