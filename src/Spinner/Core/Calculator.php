<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

class Calculator
{
    public static function computeErasingLen(array $strings): int
    {
        // TODO remove code duplicate from Settings::class
        if (empty($strings)) {
            return 0;
        }
        return self::compErasingLen($strings);
    }

    protected static function compErasingLen(array $strings): int
    {
        // TODO check if all elements have the same erasingLen
        if (null === $symbol = $strings[0]) {
            return 0;
        }
        $mbSymbolLen = mb_strlen($symbol);
        $oneCharLen = strlen($symbol) / $mbSymbolLen;
        if (4 === $oneCharLen) {
            return 2 * $mbSymbolLen;
        }
        return 1 * $mbSymbolLen;
    }
}