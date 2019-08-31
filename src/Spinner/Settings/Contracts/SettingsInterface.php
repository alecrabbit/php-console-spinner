<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings\Contracts;

use AlecRabbit\Spinner\Settings\Settings;

interface SettingsInterface
{
    /**
     * @return float
     */
    public function getInterval(): float;

    /**
     * @param float $interval
     * @return Settings
     */
    public function setInterval(float $interval): Settings;

//    /**
//     * @return int
//     */
//    public function getErasingShift(): int;
//
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @param null|int $erasingLength
     * @return Settings
     */
    public function setMessage(string $message, int $erasingLength = null): Settings;
//
//    /**
//     * @return string
//     */
//    public function getMessagePrefix(): string;
//
//    /**
//     * @param string $prefix
//     * @return Settings
//     */
//    public function setMessagePrefix(string $prefix): Settings;

    /**
     * @return string
     */
    public function getMessageSuffix(): string;

    /**
     * @param string $suffix
     * @return Settings
     */
    public function setMessageSuffix(string $suffix): Settings;

    /**
     * @return string
     */
    public function getInlinePaddingStr(): string;

    /**
     * @param string $inlinePaddingStr
     * @return Settings
     */
    public function setInlinePaddingStr(string $inlinePaddingStr): Settings;

    /**
     * @return array
     */
    public function getFrames(): array;

    /**
     * @param array $frames
     * @return Settings
     */
    public function setFrames(array $frames): Settings;

    /**
     * @return array
     */
    public function getStyles(): array;

    /**
     * @param array $styles
     * @return Settings
     */
    public function setStyles(array $styles): Settings;

    /**
     * @return int
     */
    public function getMessageErasingLen(): int;

    /**
     * @return string
     */
    public function getSpacer(): string;

    /**
     * @param string $spacer
     * @return Settings
     */
    public function setSpacer(string $spacer): Settings;

    /**
     * @param Settings $settings
     * @return Settings
     */
    public function merge(Settings $settings): Settings;
}
