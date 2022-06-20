<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

use const AlecRabbit\Cli\TERM_NOCOLOR;

interface IStylePatternExtractor
{
    public function __construct(int $terminalColorSupport = TERM_NOCOLOR);
}
