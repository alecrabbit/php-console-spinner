<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Contracts;

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
    public const COLOR =    'color';
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

    public const C_LIGHT_YELLOW = [Styles::LIGHT_YELLOW];
    public const C_LIGHT_CYAN = [Styles::LIGHT_CYAN];
    public const C_DARK = [Styles::DARK];


    /* deprecated ***
    ********/
    public const COLOR256_SPINNER_STYLES = '256_color_spinner_styles';
    public const COLOR_MESSAGE_STYLES = 'color_message_styles';
    public const COLOR_SPINNER_STYLES = 'color_spinner_styles';
    public const COLOR_PERCENT_STYLES = 'color_percent_styles';
    public const DEFAULT_MESSAGE_STYLES = [2];
    public const DEFAULT_PERCENT_STYLES = [2];
}
