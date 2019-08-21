<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contracts;

use AlecRabbit\ConsoleColour\Contracts\Styles;

interface StylesInterface
{
    public const DEFAULT_STYLES =
        [
            self::SPINNER_STYLES =>
                [
                    self::COLOR256 => self::C256_ROYAL_RAINBOW,
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
    public const STYLING_DISABLED =
        [
            self::SPINNER_STYLES =>
                [
                    self::COLOR256 => self::DISABLED,
                    self::COLOR => self::DISABLED,
                ],
            self::MESSAGE_STYLES =>
                [
                    self::COLOR256 => self::DISABLED,
                    self::COLOR => self::DISABLED,
                ],
            self::PERCENT_STYLES =>
                [
                    self::COLOR256 => self::DISABLED,
                    self::COLOR => self::DISABLED,
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

    public const C256_PURPLE_RED =
        [
            56,
            56,
            92,
            92,
            128,
            128,
            164,
            164,
            163,
            163,
            162,
            162,
            161,
            161,
            162,
            162,
            163,
            163,
            164,
            164,
            128,
            128,
            92,
            92,
        ];

    public const C256_ROYAL_BLUE_INDIAN_RED =
        [
            63,
            63,
            99,
            99,
            135,
            135,
            171,
            171,
            207,
            207,
            206,
            206,
            205,
            205,
            204,
            204,
            205,
            205,
            206,
            206,
            207,
            207,
            171,
            171,
            135,
            135,
            99,
            99,
        ];
    public const C256_ROYAL_RAINBOW =
        [
            196,
            196,
            202,
            202,
            208,
            208,
            214,
            214,
            220,
            220,
            226,
            226,
            190,
            190,
            154,
            154,
            118,
            118,
            82,
            82,
            46,
            46,
            47,
            47,
            48,
            48,
            49,
            49,
            50,
            50,
            51,
            51,
            45,
            45,
            39,
            39,
            33,
            33,
            27,
            27,
            21,
            21,
            21,
            57,
            57,
            93,
            93,
            129,
            129,
            165,
            165,
            201,
            201,
            200,
            200,
            199,
            199,
            198,
            198,
            197,
            197,
        ];

    public const C256_RAINBOW =
        [
            203,
            203,
            209,
            209,
            215,
            215,
            221,
            221,
            227,
            227,
            191,
            191,
            155,
            155,
            119,
            119,
            83,
            83,
            84,
            84,
            85,
            85,
            86,
            86,
            87,
            87,
            81,
            81,
            75,
            75,
            69,
            69,
            63,
            63,
            99,
            99,
            135,
            135,
            171,
            171,
            207,
            207,
            206,
            206,
            205,
            205,
            204,
            204,
        ];

    public const C256_YELLOW_WHITE =
        [
            226,
            227,
            228,
            229,
            229,
            230,
            230,
            230,
            231,
            231,
            231,
            231,
            230,
            230,
            230,
            229,
            229,
            228,
            227,
            226,
        ];

    public const C256_BG_RAINBOW =
        [
            [232, 203,],
            [232, 209,],
            [232, 215,],
            [232, 221,],
            [232, 227,],
            [232, 191,],
            [232, 155,],
            [232, 119,],
            [232, 83,],
            [232, 84,],
            [232, 85,],
            [232, 86,],
            [232, 87,],
            [232, 81,],
            [232, 75,],
            [232, 69,],
            [232, 63,],
            [232, 99,],
            [232, 135,],
            [232, 171,],
            [232, 207,],
            [232, 206,],
            [232, 205,],
            [232, 204,],
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
