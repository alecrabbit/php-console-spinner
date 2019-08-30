<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

class Strip
{
    protected const REG_EXP = '#\\x1b[[][^A-Za-z]*[A-Za-z]#';

    public static function escCodes(string $in): string
    {
        return preg_replace(self::REG_EXP, '', $in);
    }
}