<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings\Contracts;

interface SettingsInterface
{
    /**
     * @return float
     */
    public function getInterval(): float;

    /**
     * @param null|float $interval
     * @return SettingsInterface
     */
    public function setInterval(float $interval): SettingsInterface;

    /**
     * @return int
     */
    public function getErasingShift(): int;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param null|string $message
     * @param null|int $erasingLength
     * @return SettingsInterface
     */
    public function setMessage(string $message, int $erasingLength = null): SettingsInterface;

    /**
     * @return string
     */
    public function getMessagePrefix(): string;

    /**
     * @param null|string $prefix
     * @return SettingsInterface
     */
    public function setMessagePrefix(string $prefix): SettingsInterface;

    /**
     * @return string
     */
    public function getMessageSuffix(): string;

    /**
     * @param null|string $suffix
     * @return SettingsInterface
     */
    public function setMessageSuffix(string $suffix): SettingsInterface;

    /**
     * @return string
     */
    public function getInlinePaddingStr(): string;

    /**
     * @param null|string $inlinePaddingStr
     * @return SettingsInterface
     */
    public function setInlinePaddingStr(string $inlinePaddingStr): SettingsInterface;

    /**
     * @return array
     */
    public function getFrames(): array;

    /**
     * @param null|array $symbols
     * @return SettingsInterface
     */
    public function setFrames(array $symbols): SettingsInterface;

    /**
     * @return array
     */
    public function getStyles(): array;

    /**
     * @param null|array $styles
     * @return SettingsInterface
     */
    public function setStyles(array $styles): SettingsInterface;

    /**
     * @return int
     */
    public function getMessageErasingLen(): int;

    /**
     * @return string
     */
    public function getSpacer(): string;

    /**
     * @param null|string $spacer
     * @return SettingsInterface
     */
    public function setSpacer(string $spacer): SettingsInterface;

    /**
     * @param null|SettingsInterface $settings
     * @return SettingsInterface
     */
    public function merge(SettingsInterface $settings): SettingsInterface;

}