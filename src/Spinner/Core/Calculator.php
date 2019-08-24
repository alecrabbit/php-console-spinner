<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class Calculator
{
    public static function computeErasingLength(array $strings): int
    {
        // TODO remove code duplicate from Settings::class
        if (empty($strings)) {
            return 0;
        }
        $lengths = [];
        foreach ($strings as $string) {
            $lengths[] = self::erasingLen($string);
        }
        if (1 !== count(array_unique($lengths))) {
            throw new \InvalidArgumentException('Strings have different erasing lengths');
        }
        return $lengths[0];
    }


    /**
     * @param null|string $symbol
     * @return int
     */
    protected static function erasingLen(?string $symbol): int
    {
        if (null === $symbol || Defaults::EMPTY === $symbol) {
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
