<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Core;

class Strip
{
    protected const ANSI_ESC = '#\\x1b[[][^A-Za-z]*[A-Za-z]#';
    protected const EMPTY_STR = '';
    protected const EXCEPTION_MESSAGE = 'Failed to apply regex. Message: %s Code: %s';

    /**
     * @param string $in
     * @return string
     */
    public static function controlCodes(string $in): string
    {
        $out = preg_replace(self::ANSI_ESC, self::EMPTY_STR, $in);
        self::assertNoError();
        return (string)$out;
    }

    private static function assertNoError(): void
    {
        if (PREG_NO_ERROR !== $errorCode = preg_last_error()) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException(
                sprintf(
                    self::EXCEPTION_MESSAGE,
                    preg_last_error_msg(),
                    $errorCode
                ),
                $errorCode
            );
            // @codeCoverageIgnoreEnd
        }
    }
}
