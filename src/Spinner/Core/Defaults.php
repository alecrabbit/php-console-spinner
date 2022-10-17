<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ADefaults;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

final class Defaults extends ADefaults
{
    private static float|int $shutdownDelay = self::SHUTDOWN_DELAY;
    private static float|int $maxShutdownDelay = self::MAX_SHUTDOWN_DELAY;
    private static float|int $maxIntervalMilliseconds = self::MILLISECONDS_MAX_INTERVAL;
    private static float|int $minIntervalMilliseconds = self::MILLISECONDS_MIN_INTERVAL;
    private static bool $isModeSynchronous = self::MODE_IS_SYNCHRONOUS;
    private static bool $hideCursor = self::HIDE_CURSOR;
    private static string $finalMessage = self::FINAL_MESSAGE;
    private static string $messageOnExit = self::MESSAGE_ON_EXIT;
    private static string $interruptMessage = self::INTERRUPT_MESSAGE;
    private static string $progressFormat = self::PROGRESS_FORMAT;

    private static array $colorSupportLevels = self::COLOR_SUPPORT_LEVELS;
    private static ?array $defaultStylePattern = null;
    private static ?array $defaultCharPattern = null;
    private static ?array $spinnerStylePattern = null;
    private static ?array $spinnerCharPattern = null;
    private static ?CharFrame $spinnerTrailingSpacer = null;

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

    public static function setMaxIntervalMilliseconds(float|int $maxIntervalMilliseconds): void
    {
        self::$maxIntervalMilliseconds = $maxIntervalMilliseconds;
    }

    public static function isModeSynchronous(): bool
    {
        return self::$isModeSynchronous;
    }

    public static function setModeAsSynchronous(bool $isModeSynchronous): void
    {
        self::$isModeSynchronous = $isModeSynchronous;
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

    /**
     * @throws InvalidArgumentException
     */
    public static function setColorSupportLevels(array $colorSupportLevels): void
    {
        self::assertColorSupportLevels($colorSupportLevels);
        self::$colorSupportLevels = $colorSupportLevels;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertColorSupportLevels(array $colorSupportLevels): void
    {
        if ($colorSupportLevels === []) {
            throw new InvalidArgumentException('Color support levels must not be empty.');
        }
        foreach ($colorSupportLevels as $level) {
            if (!in_array($level, ALLOWED_TERM_COLOR, true)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Color support level "%s" is not allowed. Allowed values are [%s].',
                        $level,
                        implode(', ', ALLOWED_TERM_COLOR)
                    )
                );
            }
        }
    }

    public static function getProgressFormat(): string
    {
        return self::$progressFormat;
    }

    public static function setProgressFormat(string $progressFormat): void
    {
        self::$progressFormat = $progressFormat;
    }

    public static function getSpinnerStylePattern(): array
    {
        // TODO (2022-10-14 16:03) [Alec Rabbit]: change return type to ? [e68824d4-3908-49e4-9daf-73777963d37b]
        if (null === self::$spinnerStylePattern) {
            self::$spinnerStylePattern = StylePattern::rainbow();
        }
        return self::$spinnerStylePattern;
    }

    public static function setSpinnerStylePattern(array $spinnerStylePattern): void
    {
        self::$spinnerStylePattern = $spinnerStylePattern;
    }

    public static function getSpinnerCharPattern(): array
    {
        // TODO (2022-10-14 16:03) [Alec Rabbit]: change return type to ? [f96f5d87-f9f9-46dc-a45b-8eecc2aba711]
        if (null === self::$spinnerCharPattern) {
            self::$spinnerCharPattern = CharPattern::SNAKE_VARIANT_0;
        }
        return self::$spinnerCharPattern;
    }

    public static function setSpinnerCharPattern(array $spinnerCharPattern): void
    {
        self::$spinnerCharPattern = $spinnerCharPattern;
    }

    public static function getSpinnerTrailingSpacer(): ICharFrame
    {
        if (null === self::$spinnerTrailingSpacer) {
            self::$spinnerTrailingSpacer = CharFrame::createSpace();
        }
        return self::$spinnerTrailingSpacer;
    }

    public static function setSpinnerTrailingSpacer(ICharFrame $spinnerTrailingSpacer): void
    {
        self::$spinnerTrailingSpacer = $spinnerTrailingSpacer;
    }

    public static function reset(): void
    {
        self::$minIntervalMilliseconds = self::MILLISECONDS_MIN_INTERVAL;
        self::$maxIntervalMilliseconds = self::MILLISECONDS_MAX_INTERVAL;
        self::$isModeSynchronous = self::MODE_IS_SYNCHRONOUS;
        self::$hideCursor = self::HIDE_CURSOR;
        self::$shutdownDelay = self::SHUTDOWN_DELAY;
        self::$finalMessage = self::FINAL_MESSAGE;
        self::$messageOnExit = self::MESSAGE_ON_EXIT;
        self::$interruptMessage = self::INTERRUPT_MESSAGE;
        self::$maxShutdownDelay = self::MAX_SHUTDOWN_DELAY;
        self::$colorSupportLevels = self::COLOR_SUPPORT_LEVELS;
        self::$progressFormat = self::PROGRESS_FORMAT;
        self::$defaultStylePattern = null;
        self::$defaultCharPattern = null;
        self::$spinnerStylePattern = null;
        self::$spinnerCharPattern = null;
        self::$spinnerTrailingSpacer = null;
    }
}
