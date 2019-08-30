<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contracts;

interface Juggler
{
    public const COLOR256 = 'color256';
    public const COLOR = 'color';
//    public const NO_COLOR = 'no_color'; // Not used anywhere

    public const FRAMES_STYLES = 'spinner_styles';
    public const MESSAGE_STYLES = 'message_styles';
    public const PROGRESS_STYLES = 'percent_styles';


}