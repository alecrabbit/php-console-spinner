<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

class Strip
{
    protected const REG_EXP = '#\\x1b[[][^A-Za-z]*[A-Za-z]#';

    /**
     * @param string $in
     * @return string
     */
    public static function controlCodes(string $in): string
    {
        $out = preg_replace(self::REG_EXP, '', $in);
        self::assertNoError();
        return (string)$out;
    }

    private static function assertNoError(): void
    {
        if (PREG_NO_ERROR !== $errorCode = preg_last_error()) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException(
                sprintf(
                    'Failed to apply regex. Message: %s Code: %s',
                    preg_last_error_msg(),
                    $errorCode
                ),
                $errorCode
            );
            // @codeCoverageIgnoreEnd
        }
    }
}
