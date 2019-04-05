<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Contracts;

interface SpinnerInterface
{
    public const DEFAULT_PREFIX = ' ';
    public const DEFAULT_SUFFIX = '...';
    public const DEFAULT_MESSAGE = '';
    public const DEFAULT_PADDING_STR = ' ';
    public const PADDING_INLINE = ' ';
    public const PADDING_NEXT_LINE = '';

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
     * @return string
     */
    public function spin(): string;

    /**
     * @return string
     */
    public function erase(): string;

    /**
     * @return string
     */
    public function end(): string;
}
