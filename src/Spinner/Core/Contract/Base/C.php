<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core\Contract\Base;

final class C
{
    public const EMPTY_STRING = '';
    public const DEFAULT_MESSAGE = self::EMPTY_STRING;
    public const SPACE_CHAR = ' ';
    public const FORMAT = 'format';
    public const SEQUENCE = 'sequence';
    public const INTERVAL = 'interval';
    public const STYLES = 'styles';

    private function __construct()
    {
    }
}
