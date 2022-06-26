<?php

declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;
use const AlecRabbit\Cli\TERM_NOCOLOR;

final class StylePattern
{
    public static function rainbow(): array
    {
        return
            self::fillWithDefaults(
                [
                    C::STYLES => [
                        TERM_16COLOR =>
                            [
                                C::SEQUENCE => [96,],
                                C::FORMAT => '%sm',
                                C::INTERVAL => null,
                            ],
                        TERM_256COLOR =>
                            [
                                C::SEQUENCE => [
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
                                C::FORMAT => '38;5;%sm',
                                C::INTERVAL => 200,
                            ],
                    ],
                ],
                self::defaults()
            );
    }

    protected static function fillWithDefaults(array $incoming, array $defaults): array
    {
        foreach ($defaults as $key => $value) {
            if (is_array($value)) {
                if (!array_key_exists($key, $incoming)) {
                    $incoming[$key] = [];
                }
                $incoming[$key] = self::fillWithDefaults($incoming[$key], $value);
            } elseif (!array_key_exists($key, $incoming)) {
                $incoming[$key] = $value;
            }
        }
        return $incoming;
    }

    #[ArrayShape([C::STYLES => "array[]"])]
    protected static function defaults(): array
    {
        return [
            C::STYLES => [
                TERM_NOCOLOR =>
                    [
                        C::SEQUENCE => [StyleFrame::createEmpty()],
                        C::FORMAT => null,
                        C::INTERVAL => null,
                    ],
            ],
        ];
    }

    public static function red(): array
    {
        return
            self::fillWithDefaults(
                [
                    C::STYLES => [
                        TERM_16COLOR =>
                            [
                                C::SEQUENCE => [31, 32,],
                                C::FORMAT => '%sm',
                                C::INTERVAL => 1000,
                            ],
                        TERM_256COLOR =>
                            [
                                C::SEQUENCE => [1, 2,],
                                C::FORMAT => '38;5;%sm',
                                C::INTERVAL => 1000,
                            ],
                    ],
                ],
                self::defaults()
            );
    }

    public static function none(): array
    {
        return
            self::fillWithDefaults(
                [
                    C::STYLES => [
                    ],
                ],
                self::defaults()
            );
    }

    #[ArrayShape([C::STYLES => "array[]"])]
    public static function rainbowBg(): array
    {
        return
            [
                C::STYLES => [
                    TERM_16COLOR =>
                        [
                            C::SEQUENCE => [96,],
                            C::FORMAT => '%sm',
                            C::INTERVAL => null,
                        ],
                    TERM_256COLOR =>
                        [
                            C::SEQUENCE => [
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
                            C::FORMAT => '48;5;%sm',
                            C::INTERVAL => 200,
                        ],
                ],
            ];
    }
}
