<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Styles;

interface SpinnerStyles
{
    public const DISABLED = null;

    public const C256_RAINBOW =
        [203, 209, 215, 221, 227, 191, 155, 119, 83, 84, 85, 86, 87, 81, 75, 69, 63, 99, 135, 171, 207, 206, 205, 204,];

    public const C256_YELLOW_WHITE =
        [226, 227, 228, 229, 230, 231, 230, 229, 228, 227, 226];

    public const C_LIGHT_YELLOW =
        [Styles::LIGHT_YELLOW];

    public const C_LIGHT_CYAN =
        [Styles::LIGHT_CYAN];
}
