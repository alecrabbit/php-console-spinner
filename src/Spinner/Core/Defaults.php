<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ADefaults;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

final class Defaults extends ADefaults
{
    private static float|int $shutdownDelay = self::SHUTDOWN_DELAY;
    private static float|int $maxShutdownDelay = self::MAX_SHUTDOWN_DELAY;
    private static float|int $maxIntervalMilliseconds = self::MILLISECONDS_MAX_INTERVAL;
    private static float|int $minIntervalMilliseconds = self::MILLISECONDS_MIN_INTERVAL;
    private static bool $synchronousMode = self::SYNCHRONOUS_MODE;
    private static bool $hideCursor = self::HIDE_CURSOR;
    private static string $finalMessage = self::FINAL_MESSAGE;
    private static string $messageOnExit = self::MESSAGE_ON_EXIT;
    private static string $interruptMessage = self::MESSAGE_INTERRUPTED;

    private static array $colorSupportLevels = self::COLOR_SUPPORT_LEVELS;
    private static ?array $defaultStylePattern = null;
    private static ?array $defaultCharPattern = null;

    public static function getMinIntervalMilliseconds(): float|int
    {
        return self::$minIntervalMilliseconds;
    }

    public static function setMinIntervalMilliseconds(float|int $minIntervalMilliseconds): void
    {
        self::$minIntervalMilliseconds = $minIntervalMilliseconds;
    }

    public static function getMaxIntervalMilliseconds(): float|int
    {
        return self::$maxIntervalMilliseconds;
    }

    public static function getSynchronousMode(): bool
    {
        return self::$synchronousMode;
    }

    public static function setSynchronousMode(bool $synchronousMode): void
    {
        self::$synchronousMode = $synchronousMode;
    }

    public static function getHideCursor(): bool
    {
        return self::$hideCursor;
    }

    public static function setHideCursor(bool $hideCursor): void
    {
        self::$hideCursor = $hideCursor;
    }

    public static function getShutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public static function setShutdownDelay(float|int $shutdownDelay): void
    {
        self::$shutdownDelay = $shutdownDelay;
    }

    public static function getDefaultCharPattern(): array
    {
        if (null === self::$defaultCharPattern) {
            self::$defaultCharPattern = CharPattern::none();
        }
        return self::$defaultCharPattern;
    }

    public static function setDefaultCharPattern(array $char): void
    {
        self::$defaultCharPattern = $char;
    }

    public static function getDefaultStylePattern(): array
    {
        if (null === self::$defaultStylePattern) {
            self::$defaultStylePattern = StylePattern::none();
        }
        return self::$defaultStylePattern;
    }

    public static function setDefaultStylePattern(array $style): void
    {
        self::$defaultStylePattern = $style;
    }

    public static function getFinalMessage(): string
    {
        return self::$finalMessage;
    }

    public static function setFinalMessage(string $finalMessage): void
    {
        self::$finalMessage = $finalMessage;
    }

    public static function getMessageOnExit(): string
    {
        return self::$messageOnExit;
    }

    public static function setMessageOnExit(string $messageOnExit): void
    {
        self::$messageOnExit = $messageOnExit;
    }

    public static function getInterruptMessage(): string
    {
        return self::$interruptMessage;
    }

    public static function setInterruptMessage(string $interruptMessage): void
    {
        self::$interruptMessage = $interruptMessage;
    }

    public static function getMaxShutdownDelay(): float|int
    {
        return self::$maxShutdownDelay;
    }

    public static function setMaxShutdownDelay(float|int $maxShutdownDelay): void
    {
        self::$maxShutdownDelay = $maxShutdownDelay;
    }

    public static function getColorSupportLevels(): array
    {
        return self::$colorSupportLevels;
    }

    public static function setColorSupportLevels(array $colorSupportLevels): void
    {
        foreach ($colorSupportLevels as $level) {
            if (!in_array($level, ALLOWED_TERM_COLOR, true)) {
                throw new InvalidArgumentException(
                    sprintf('Color support level "%s" is not allowed.', $level)
                );
            }
        }
        self::$colorSupportLevels = $colorSupportLevels;
    }
}
