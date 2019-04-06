<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\ConsoleColour\ConsoleColor;

class Helper
{
    /**
     * @param string $str $str
     * @return mixed
     */
    public static function stripEscape(string $str)
    {
        return str_replace(ConsoleColor::ESC_CHAR, '\033', $str);
    }
}