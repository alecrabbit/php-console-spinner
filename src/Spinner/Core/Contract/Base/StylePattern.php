<?php

declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Core\Contract\Base;

use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;

final class StylePattern
{
    public static function rainbow(): array
    {
        return
            [
                'styles' => [
                    TERM_16COLOR =>
                        [
                            'sequence' => [96,],
                        ],
                    TERM_256COLOR =>
                        [
                            'sequence' => [
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
                            ],
                        ],
                ],
                'interval' => 200,
            ];
    }
}
