<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use function AlecRabbit\Helpers\wcswidth;

class Calculator
{
    /**
     * @param array $strings
     * @return int
     */
    public static function computeErasingWidths(array $strings): int
    {
        if (empty($strings)) {
            return 0;
        }
        $lengths = [];
        foreach ($strings as $key => $string) {
            $length = self::computeErasingWidth($string);
            $lengths[] = $length;
            $strings[$key] = [$length, $string];
        }
        if (1 !== count(array_unique($lengths))) {
            // dump($strings);
            throw new \InvalidArgumentException('Strings have different erasing lengths.');
        }
        return $lengths[0];
    }

    /**
     * @param null|string $in
     * @return int
     */
    public static function computeErasingWidth(?string $in): int
    {
        if (null === $in || Defaults::EMPTY_STRING === $in) {
            return 0;
        }
        $in = Strip::controlCodes($in);
        return wcswidth($in);
    }
}
