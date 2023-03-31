<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Helper;

use Throwable;

final class Stringify
{
    private const FORMAT = '%s(%s)';
    private const FORMAT_THROWABLE = "%s('%s')";

    public static function value(mixed $value, bool $unwrap = true): string
    {
        $type = gettype($value);
        return match ($unwrap) {
            true => self::unwrapValue($value, $type),
            false => $type,
        };
    }

    protected static function unwrapValue(mixed $value, string $type): string
    {
        return match (true) {
            is_scalar($value) => self::unwrapScalar($value, $type),
            is_object($value) => self::unwrapObject($value, $type),
            default => $type,
        };
    }

    private static function unwrapScalar(mixed $value, string $type): string
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        return sprintf(self::FORMAT, $type, $value);
    }

    private static function unwrapObject(object $value, string $type): string
    {
        if ($value instanceof Throwable) {
            return self::throwable($value);
        }
        return sprintf(self::FORMAT, $type, get_class($value));
    }

    public static function throwable(Throwable $t, bool $unwrap = true): string
    {
        $class = get_class($t);
        $message = $t->getMessage();
        $aux = $unwrap ? ' [' . $class . ']' : '';
        return
            sprintf(
                self::FORMAT_THROWABLE,
                self::shortClassName($class),
                $message
            ) . $aux;
    }

    public static function shortClassName(string|object $fqcn): string
    {
        if (is_object($fqcn)) {
            $fqcn = get_class($fqcn);
        }
        $parts = explode('\\', $fqcn);
        return end($parts);
    }
}
