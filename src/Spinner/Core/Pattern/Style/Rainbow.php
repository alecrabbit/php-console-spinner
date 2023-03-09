<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Pattern\Style;

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Pattern\Style\A\APatternStyle;

final class Rainbow extends APatternStyle
{
    public function getMode(): ColorMode
    {
        return ColorMode::ANSI8;
    }
    public function getPattern(): iterable
    {
        return [
                196,
                202,
                208,
                214,
                220,
                226,
                190,
                154,
                118,
                82,
                46,
                47,
                48,
                49,
                50,
                51,
                45,
                39,
                33,
                27,
                56,
                57,
                93,
                129,
                165,
                201,
                200,
                199,
                198,
                197,
        ];
    }
}