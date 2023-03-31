<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Helper;

use ReflectionException;
use Throwable;

final class Stringify
{
    private const FORMAT = '%s(%s)';
    private const FORMAT_THROWABLE = '%s("%s")';

    public static function value(mixed $value, bool $unwrap = true): string
    {
        $type = gettype($value);
        if (!$unwrap) {
            return $type;
        }
        if (is_scalar($value)) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            return sprintf(self::FORMAT, $type, $value);
        }
        if (is_object($value)) {
            return sprintf(self::FORMAT, $type, get_class($value));
        }
        return $type;
    }

    /**
     * @throws ReflectionException
     */
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
            ). $aux;
    }

    /**
     * @throws ReflectionException
     */
    public static function shortClassName(string|object $fqcn): string
    {
        return (new \ReflectionClass($fqcn))->getShortName();
    }
}
