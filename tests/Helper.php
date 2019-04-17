<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use const AlecRabbit\ESC;

class Helper
{
    /**
     * @param string $str $str
     * @return mixed
     */
    public static function stripEscape(string $str)
    {
        return str_replace(ESC, '\033', $str);
    }
}
