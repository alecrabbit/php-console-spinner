<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract\Color\Style;

enum StyleOption
{
    case BOLD;
    case DIM;
    case ITALIC;
    case UNDERLINE;
    case BLINK;
    case REVERSE;
    case HIDDEN;
    case STRIKETHROUGH;
    case DOUBLE_UNDERLINE;
}
