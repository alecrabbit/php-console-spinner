<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Contracts;

interface SpinnerInterface
{
    public const DEFAULT_PREFIX = ' ';
    public const DEFAULT_SUFFIX = '...';
    public const DEFAULT_MESSAGE = '';

    /**
     * @return string
     */
    public function begin(): string;

    /**
     * @return string
     */
    public function spin(): string;

    /**
     * @return string
     */
    public function end(): string;
}
