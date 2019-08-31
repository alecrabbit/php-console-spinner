<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

class Strip
{
    protected const REG_EXP = '#\\x1b[[][^A-Za-z]*[A-Za-z]#';

    public static function escCodes(string $in): string
    {
        $str = preg_replace(self::REG_EXP, '', $in);
        if (PREG_NO_ERROR !== $error = preg_last_error()) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException('Failed to apply regex. Code: ' . $error, $error);
            // @codeCoverageIgnoreEnd
        }
        return (string)$str;
    }
}
