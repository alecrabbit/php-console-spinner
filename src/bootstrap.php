<?php

declare(strict_types=1);

namespace AlecRabbit\Cli;

// @codeCoverageIgnoreStart
if (!defined(__NAMESPACE__ . '\\' . 'ESC')) {
    define(__NAMESPACE__ . '\\' . 'ESC', "\033");
    define(__NAMESPACE__ . '\\' . 'CSI', ESC . '[');
    define(__NAMESPACE__ . '\\' . 'RESET', ESC . '[0m');

    define(__NAMESPACE__ . '\\' . 'TERM_TRUECOLOR', 65535);
    define(__NAMESPACE__ . '\\' . 'TERM_256COLOR', 255);
    define(__NAMESPACE__ . '\\' . 'TERM_16COLOR', 16);
    define(__NAMESPACE__ . '\\' . 'TERM_NOCOLOR', 0);

    define(
        __NAMESPACE__ . '\\' . 'ALLOWED_TERM_COLOR',
        [
            TERM_NOCOLOR,
            TERM_16COLOR,
            TERM_256COLOR,
            TERM_TRUECOLOR,
        ]
    );
}
