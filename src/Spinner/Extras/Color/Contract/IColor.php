<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\Contract;

interface IColor
{
    public const FORMAT_HEX = '#%02x%02x%02x';
    public const FORMAT_HSL = 'hsl(%d, %s%%, %s%%)';
    public const FORMAT_HSLA = 'hsla(%d, %s%%, %s%%, %s)';
    public const FORMAT_RGB = 'rgb(%d, %d, %d)';
    public const FORMAT_RGBA = 'rgba(%d, %d, %d, %s)';

    public const REGEXP_HEX = '/^#?(?:([a-f\d]{2}){3}|([a-f\d]){3})$/i';
    public const REGEXP_HSLA = '/^hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)$/';
    public const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';
}
