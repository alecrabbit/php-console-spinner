<?php

declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Core\Contract\Base;

use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;
use const AlecRabbit\Cli\TERM_NOCOLOR;
use const AlecRabbit\Cli\TERM_TRUECOLOR;

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
                            ],
                    ],
                    C::INTERVAL => 200,
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

    #[ArrayShape([C::STYLES => "\array[][]", C::INTERVAL => "int"])]
    protected static function defaults(): array
    {
        return [
            C::STYLES => [
                TERM_NOCOLOR =>
                    [
                        C::SEQUENCE => [],
                        C::FORMAT => '',
                    ],
                TERM_16COLOR =>
                    [
                        C::SEQUENCE => [],
                        C::FORMAT => '',
                    ],
                TERM_256COLOR =>
                    [
                        C::SEQUENCE => [],
                        C::FORMAT => '',
                    ],
                TERM_TRUECOLOR =>
                    [
                        C::SEQUENCE => [],
                        C::FORMAT => '',
                    ],
            ],
            C::INTERVAL => 1000,
        ];
    }
}
