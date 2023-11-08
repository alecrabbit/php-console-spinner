<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use Throwable;

final class Stringify
{
    private const FORMAT = '%s(%s)';
    private const FORMAT_THROWABLE = "%s('%s')";

    public static function value(mixed $value, bool $unwrap = true): string
    {
        $type = gettype($value);
        return
            match ($unwrap) {
                true => self::unwrapValue($value, $type),
                false => $type,
            };
    }

    private static function unwrapValue(mixed $value, string $type): string
    {
        return
            match (true) {
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
        return sprintf(self::FORMAT, $type, (string)$value);
    }

    private static function unwrapObject(object $value, string $type): string
    {
        if ($value instanceof Throwable) {
            return self::throwable($value);
        }
        return sprintf(self::FORMAT, $type, $value::class);
    }

    public static function throwable(Throwable $t, bool $unwrap = true): string
    {
        $class = $t::class;
        $message = $t->getMessage();
        $aux = $unwrap ? ' [' . $class . ']' : '';
        return sprintf(
                self::FORMAT_THROWABLE,
                self::classShortName($class),
                $message
            ) . $aux;
    }

    public static function classShortName(string|object $fqcn): string
    {
        if (is_object($fqcn)) {
            $fqcn = $fqcn::class;
        }
        $parts = explode('\\', $fqcn);
        return end($parts);
    }
}
