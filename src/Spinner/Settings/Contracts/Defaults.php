<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Settings\Contracts;

interface Defaults
{
    public const DEFAULT_SUFFIX = '...';
    public const ONE_SPACE_SYMBOL = ' ';
    public const EMPTY = '';

    public const MAX_FRAMES_COUNT = 50;

    public const DEFAULT_INTERVAL = 0.1;
    public const DEFAULT_FRAMES = [];
}