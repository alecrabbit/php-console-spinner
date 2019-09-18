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

    /**
     * @return bool
     */
    public function isHideCursor(): bool;

    /**
     * @param bool $value
     * @return Settings
     */
    public function setHideCursor($value = true): Settings;

    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @param bool $enabled
     * @return Settings
     */
    public function setEnabled(bool $enabled = true): Settings;

    /**
     * @return null|string
     */
    public function getMessage(): ?string;

    /**
     * @param string $message
     * @return Settings
     */
    public function setMessage(string $message): Settings;

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
    public function getMessageErasingLength(): int;

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
     * @return null|float
     */
    public function getInitialPercent(): ?float;

    /**
     * @param null|float $percent
     * @return Settings
     */
    public function setInitialPercent(?float $percent): Settings;

    /**
     * @param Settings $settings
     * @return Settings
     */
    public function merge(Settings $settings): Settings;

    /**
     * @return array
     */
    public function getJugglersOrder(): array;

    /**
     * @param array $order
     * @return Settings
     */
    public function setJugglersOrder(array $order): Settings;
}
