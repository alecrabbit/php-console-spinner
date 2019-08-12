<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

interface SettingsInterface
{
    public const MAX_SYMBOLS_COUNT = 50;

    public const DEFAULT_SUFFIX = '...';
    public const ONE_SPACE_SYMBOL = ' ';
    public const EMPTY = '';

    public const DEFAULT_INTERVAL = 0.1;
    public const DEFAULT_ERASING_SHIFT = 1;
    public const DEFAULT_SYMBOLS = SpinnerSymbols::BASE;

    /**
     * @return float
     */
    public function getInterval(): float;

    /**
     * @param null|float $interval
     * @return SettingsInterface
     */
    public function setInterval(?float $interval): SettingsInterface;

//    /**
//     * @return int
//     */
//    public function getErasingShift(): int;
//
//    /**
//     * @param null|int $erasingShift
//     * @return SettingsInterface
//     */
//    public function setErasingShift(?int $erasingShift): SettingsInterface;
//
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param null|string $string
     * @return SettingsInterface
     */
    public function setMessage(?string $string): SettingsInterface;

    /**
     * @return string
     */
    public function getPrefix(): string;

    /**
     * @param null|string $prefix
     * @return SettingsInterface
     */
    public function setPrefix(?string $prefix): SettingsInterface;

    /**
     * @return string
     */
    public function getSuffix(): string;

    /**
     * @param null|string $suffix
     * @return SettingsInterface
     */
    public function setSuffix(?string $suffix): SettingsInterface;

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
    public function getSymbols(): array;

    /**
     * @param null|array $symbols
     * @return SettingsInterface
     */
    public function setSymbols(?array $symbols): SettingsInterface;

    /**
     * @return array
     */
    public function getStyles(): array;

    /**
     * @param null|array $styles
     * @return SettingsInterface
     */
    public function setStyles(?array $styles): SettingsInterface;
}
