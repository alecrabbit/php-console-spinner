<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class Calculator
{
    /**
     * @param array $strings
     * @return int
     */
    public static function computeErasingLengths(array $strings): int
    {
        if (empty($strings)) {
            return 0;
        }
        $lengths = [];
        foreach ($strings as $key => $string) {
            $length = self::computeErasingLength($string);
            $lengths[] = $length;
            $strings[$key] = [$length, $string];
        }
        if (1 !== count(array_unique($lengths))) {
            throw new \InvalidArgumentException('Strings have different erasing lengths.');
        }
        return $lengths[0];
    }

    /**
     * @param null|string $in
     * @return int
     */
    public static function computeErasingLength(?string $in): int
    {
        if (null === $in || Defaults::EMPTY_STRING === $in) {
            return 0;
        }
        $in = Strip::escCodes($in);
        $mbSymbolLen = mb_strlen($in);
        $oneCharLen = strlen($in) / $mbSymbolLen;
        if (4 === $oneCharLen) {
            return 2 * $mbSymbolLen;
        }
        return mb_strwidth($in);
    }
}
