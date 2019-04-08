<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Contracts;

interface SpinnerInterface
{
    public const DEFAULT_PREFIX = ' ';
    public const DEFAULT_SUFFIX = '...';
    public const DEFAULT_MESSAGE = '';
    public const PADDING_SPACE_SYMBOL = ' ';
    public const PADDING_EMPTY = '';

    /**
     * @return string
     */
    public function begin(): string;

    /**
     * @param bool $inline
     * @return SpinnerInterface
     */
    public function inline(bool $inline): SpinnerInterface;

    /**
     * @param null|float $percent
     * @return string
     */
    public function spin(?float $percent = null): string;

    /**
     * @return string
     */
    public function erase(): string;

    /**
     * @return string
     */
    public function end(): string;
}
