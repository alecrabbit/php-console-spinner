<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

interface SettingsInterface
{
    public const MAX_FRAMES_COUNT = 50;

    public const DEFAULT_SUFFIX = '...';
    public const ONE_SPACE_SYMBOL = ' ';
    public const EMPTY = '';

    public const DEFAULT_INTERVAL = 0.1;
    public const DEFAULT_FRAMES = Frames::BASE;

    /**
     * @return float
     */
    public function getInterval(): float;

    /**
     * @param null|float $interval
     * @return SettingsInterface
     */
    public function setInterval(?float $interval): SettingsInterface;

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
     * @param null|int $erasingLen
     * @return SettingsInterface
     */
    public function setMessage(?string $message, ?int $erasingLen = null): SettingsInterface;

    /**
     * @return string
     */
    public function getMessagePrefix(): string;

    /**
     * @param null|string $prefix
     * @return SettingsInterface
     */
    public function setMessagePrefix(?string $prefix): SettingsInterface;

    /**
     * @return string
     */
    public function getMessageSuffix(): string;

    /**
     * @param null|string $suffix
     * @return SettingsInterface
     */
    public function setMessageSuffix(?string $suffix): SettingsInterface;

    /**
     * @return string
     */
    public function getInlinePaddingStr(): string;

    /**
     * @param null|string $inlinePaddingStr
     * @return SettingsInterface
     */
    public function setInlinePaddingStr(?string $inlinePaddingStr): SettingsInterface;

    /**
     * @return array
     */
    public function getFrames(): array;

    /**
     * @param null|array $symbols
     * @return SettingsInterface
     */
    public function setFrames(?array $symbols): SettingsInterface;

    /**
     * @return array
     */
    public function getStyles(): array;

    /**
     * @param null|array $styles
     * @return SettingsInterface
     */
    public function setStyles(?array $styles): SettingsInterface;

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
    public function setSpacer(?string $spacer): SettingsInterface;

    /**
     * @param null|SettingsInterface $settings
     * @return SettingsInterface
     */
    public function merge(?SettingsInterface $settings): SettingsInterface;
}
