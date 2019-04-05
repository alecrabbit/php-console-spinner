<?php declare(strict_types=1);

use AlecRabbit\ConsoleColour\ConsoleColor;

function showCursorSequence(): string
{
    return ConsoleColor::ESC_CHAR . '[?25h' . ConsoleColor::ESC_CHAR . '[?0c';
}

function hideCursorSequence(): string
{
    return ConsoleColor::ESC_CHAR . '[?25l';
}
