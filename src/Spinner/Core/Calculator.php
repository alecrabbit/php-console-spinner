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
        $widths = [];
        foreach ($strings as $key => $string) {
            $width = self::computeErasingWidth($string);
            $widths[] = $width;
//            $strings[$key] = [$width, $string]; // debug line
        }
        if (1 !== count(array_unique($widths))) {
//             dump($strings); // debug line
            throw new \InvalidArgumentException('Strings have different erasing widths.');
        }
        return $widths[0];
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
