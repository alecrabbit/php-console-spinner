<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Styles;

interface StylesInterface
{
    public const DEFAULT_STYLES =
        [
            self::SPINNER_STYLES =>
                [
                    self::COLOR256 => self::C256_RAINBOW,
                    self::COLOR => self::C_DARK,
                ],
            self::MESSAGE_STYLES =>
                [
                    self::COLOR256 => self::DISABLED,
                    self::COLOR => self::C_DARK,
                ],
            self::PERCENT_STYLES =>
                [
                    self::COLOR256 => self::DISABLED,
                    self::COLOR => self::C_DARK,
                ],
        ];

    /*
                    Definitions
    */
    public const COLOR256 = 'color256';
    public const COLOR = 'color';
    public const NO_COLOR = 'no_color';

    public const SPINNER_STYLES = 'spinner_styles';
    public const MESSAGE_STYLES = 'message_styles';
    public const PERCENT_STYLES = 'percent_styles';

    /*
                    Styles
    */
    public const DISABLED = null;

    public const C256_RAINBOW =
        [203, 209, 215, 221, 227, 191, 155, 119, 83, 84, 85, 86, 87, 81, 75, 69, 63, 99, 135, 171, 207, 206, 205, 204,];

    public const C256_YELLOW_WHITE =
        [226, 227, 228, 229, 230, 231, 230, 229, 228, 227, 226];

    public const C256_BG_RAINBOW =
        [
           [ 232, 203,],
           [ 232, 209,],
           [ 232, 215,],
           [ 232, 221,],
           [ 232, 227,],
           [ 232, 191,],
           [ 232, 155,],
           [ 232, 119,],
           [ 232, 83,],
           [ 232, 84,],
           [ 232, 85,],
           [ 232, 86,],
           [ 232, 87,],
           [ 232, 81,],
           [ 232, 75,],
           [ 232, 69,],
           [ 232, 63,],
           [ 232, 99,],
           [ 232, 135,],
           [ 232, 171,],
           [ 232, 207,],
           [ 232, 206,],
           [ 232, 205,],
           [ 232, 204,],
        ];

    public const C256_BG_YELLOW_WHITE =
        [
            [232, 231,],
            [232, 230,],
            [232, 229,],
            [232, 228,],
            [232, 227,],
            [232, 226,],
            [232, 226,],
            [232, 227,],
            [232, 228,],
            [232, 229,],
            [232, 230,],
        ];

    public const C_LIGHT_YELLOW = [Styles::LIGHT_YELLOW];
    public const C_LIGHT_CYAN = [Styles::LIGHT_CYAN];
    public const C_DARK = [Styles::DARK];
}
