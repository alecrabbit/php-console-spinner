<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

interface Juggler
{
    public const COLOR256 = 'color256';
    public const COLOR = 'color';
//    public const NO_COLOR = 'no_color'; // Not used anywhere
    public const FORMAT = 'format';
    public const SPACER = 'spacer';

    public const FRAMES_STYLES = 'spinner_styles';
    public const MESSAGE_STYLES = 'message_styles';
    public const PROGRESS_STYLES = 'percent_styles';

    public const FRAMES = 0;
    public const MESSAGE = 1;
    public const PROGRESS = 2;
}
