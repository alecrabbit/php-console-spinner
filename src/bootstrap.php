<?php

declare(strict_types=1);

namespace AlecRabbit\Cli {
    // @codeCoverageIgnoreStart
    if (!defined(__NAMESPACE__ . '\\' . 'ESC')) {
        define(__NAMESPACE__ . '\\' . 'ESC', "\033");
        define(__NAMESPACE__ . '\\' . 'CSI', ESC . '[');
        define(__NAMESPACE__ . '\\' . 'RESET', ESC . '[0m');

        define(__NAMESPACE__ . '\\' . 'TERM_TRUECOLOR', 65535);
        define(__NAMESPACE__ . '\\' . 'TERM_256COLOR', 255);
        define(__NAMESPACE__ . '\\' . 'TERM_16COLOR', 16);
        define(__NAMESPACE__ . '\\' . 'TERM_NOCOLOR', 0);
    }
    // @codeCoverageIgnoreEnd
}

namespace AlecRabbit\Spinner {
    // @codeCoverageIgnoreStart
    if (!defined(__NAMESPACE__ . '\\' . 'ESC')) {
        define(__NAMESPACE__ . '\\' . 'ESC', \AlecRabbit\Cli\ESC);
        define(__NAMESPACE__ . '\\' . 'CSI', \AlecRabbit\Cli\CSI);
        define(__NAMESPACE__ . '\\' . 'RESET', \AlecRabbit\Cli\RESET);

        define(__NAMESPACE__ . '\\' . 'TERM_TRUE_COLOR', \AlecRabbit\Cli\TERM_TRUECOLOR);
        define(__NAMESPACE__ . '\\' . 'TERM_256_COLOR', \AlecRabbit\Cli\TERM_256COLOR);
        define(__NAMESPACE__ . '\\' . 'TERM_16_COLOR', \AlecRabbit\Cli\TERM_16COLOR);
        define(__NAMESPACE__ . '\\' . 'TERM_NO_COLOR', \AlecRabbit\Cli\TERM_NOCOLOR);

        define(
            __NAMESPACE__ . '\\' . 'KNOWN_TERM_COLOR',
            [
                TERM_NO_COLOR,
                TERM_16_COLOR,
                TERM_256_COLOR,
                TERM_TRUE_COLOR,
            ]
        );
    }
    // @codeCoverageIgnoreEnd
}
