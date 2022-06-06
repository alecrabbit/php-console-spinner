<?php

declare(strict_types=1);

namespace AlecRabbit\Cli;

if (!defined(__NAMESPACE__ . '\\' . 'ESC')) {
    define(__NAMESPACE__ . '\\' . 'ESC', "\033");
    define(__NAMESPACE__ . '\\' . 'CSI', ESC . '[');
}
