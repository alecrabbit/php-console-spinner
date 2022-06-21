<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Kernel\Contract\Base;

use AlecRabbit\Spinner\Core\Contract\C;

final class CharPattern
{
    public const MOON =
        [
            C::FRAMES => '🌘🌗🌖🌕🌔🌓🌒🌑',
            C::ELEMENT_WIDTH => 2,
            C::INTERVAL => 150
        ];

    public const MOON_REVERSED =
        [
            C::FRAMES => '🌑🌒🌓🌔🌕🌖🌗🌘',
            C::ELEMENT_WIDTH => 2,
            C::INTERVAL => 150
        ];

    public const EARTH =
        [
            C::FRAMES => '🌍🌎🌏',
            C::ELEMENT_WIDTH => 2,
            C::INTERVAL => 300
        ];

    public const DIAMOND =
        [
            C::FRAMES => '♦',
            C::ELEMENT_WIDTH => 1,
        ];

    public const SIMPLE =
        [
            C::FRAMES => ['/', '|', '\\', '─',],
            C::ELEMENT_WIDTH => 1,
            C::INTERVAL => 250
        ];

    public const CIRCLES = [
        C::FRAMES => ['◐', '◓', '◑', '◒',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 250
    ];

    public const RUNNER = [
        C::FRAMES => ['🚶 ', '🏃 '],
        C::ELEMENT_WIDTH => 3,
        C::INTERVAL => 400
    ];

    public const MONKEY = [
        C::FRAMES => ['🐵 ', '🙈 ', '🙉 ', '🙊 '],
        C::ELEMENT_WIDTH => 3,
        C::INTERVAL => 300
    ];

    public const SECTOR = [
        C::FRAMES => ['◴ ', '◷ ', '◶ ', '◵ '],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 250
    ];

    public const CLOCK_VARIANT_0 = [
        C::FRAMES => ['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 150
    ];

    public const CLOCK_VARIANT_1 = [
        C::FRAMES => ['🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦',],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 150
    ];

    public const CLOCK_VARIANT_2 = [
        C::FRAMES => [
            '🕐',
            '🕜',
            '🕑',
            '🕝',
            '🕒',
            '🕞',
            '🕓',
            '🕟',
            '🕔',
            '🕠',
            '🕕',
            '🕡',
            '🕖',
            '🕢',
            '🕗',
            '🕣',
            '🕘',
            '🕤',
            '🕙',
            '🕥',
            '🕚',
            '🕦',
            '🕛',
            '🕧',

        ],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 150
    ];

    public const DOT = [
        C::FRAMES => ['⢀', '⡀', '⠄', '⠂', '⠁', '⠈', '⠐', '⠠',],
        C::ELEMENT_WIDTH => 1
    ];

    public const DOT_REVERSED = [
        C::FRAMES => ['⠠', '⠐', '⠈', '⠁', '⠂', '⠄', '⡀', '⢀',],
        C::ELEMENT_WIDTH => 1
    ];

    public const ARROW_VARIANT_0 = [
        C::FRAMES => [
            '▹▹▹▹▹',
            '▸▹▹▹▹',
            '▹▸▹▹▹',
            '▹▹▸▹▹',
            '▹▹▹▸▹',
            '▹▹▹▹▸',
        ],
        C::ELEMENT_WIDTH => 5
    ];

    public const ARROW_VARIANT_1 = [
        C::FRAMES => [
            '◁ ◁ ◁ ◁ ◀',
            '◁ ◁ ◁ ◀ ◁',
            '◁ ◁ ◀ ◁ ◁',
            '◁ ◀ ◁ ◁ ◁',
            '◀ ◁ ◁ ◁ ◁',
        ],
        C::ELEMENT_WIDTH => 9
    ];

    public const ARROW_VARIANT_2 = [
        C::FRAMES => [
            '◃◃◃◃◂',
            '◃◃◃◂◃',
            '◃◃◂◃◃',
            '◃◂◃◃◃',
            '◂◃◃◃◃',
            '▸▹▹▹▹',
            '▹▸▹▹▹',
            '▹▹▸▹▹',
            '▹▹▹▸▹',
            '▹▹▹▹▸',

        ],
        C::ELEMENT_WIDTH => 5
    ];

    public const ARROW_VARIANT_3 = [
        C::FRAMES => [
            '◃◃◃◃◃',
            '◃◃◃◃◂',
            '◃◃◃◂◃',
            '◃◃◂◃◃',
            '◃◂◃◃◃',
            '◂◃◃◃◃',
        ],
        C::ELEMENT_WIDTH => 5
    ];

    public const WEATHER_VARIANT_0 = [
        C::FRAMES => [
            '☀️ ',
            '☀️ ',
            '🌤 ',
            '🌤 ',
            '⛅️',
            '🌥 ',
            '☁️ ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '⛈ ',
            '⛈ ',
            '🌨 ',
            '⛈ ',
            '🌧 ',
            '🌨 ',
            '☁️ ',
            '🌥 ',
            '⛅️',
            '🌤 ',
            '🌤 ',
            '☀️ ',
            '☀️ ',
        ],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 150
    ];


    public const WEATHER_VARIANT_1 = [
        C::FRAMES => [
            '🌤 ',
            '🌤 ',
            '🌤 ',
            '🌥 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌥 ',
            '🌤 ',
            '🌤 ',
            '🌤 ',
        ],
        C::ELEMENT_WIDTH => 2
    ];

    public const BALL_VARIANT_0 = [
        C::FRAMES => [
            '  ●     ',
            '   ●    ',
            '    ●   ',
            '     ●  ',
            '      ● ',
            '     ●  ',
            '    ●   ',
            '   ●    ',
            '  ●     ',
            ' ●      ',
        ],
        C::ELEMENT_WIDTH => 8
    ];

    public const SNAKE_VARIANT_0 = [
        C::FRAMES => ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const SNAKE_VARIANT_1 = [
        C::FRAMES => '⣇⡏⠟⠻⢹⣸⣴⣦',
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 150
    ];

    public const SNAKE_VARIANT_2 = [
        C::FRAMES => ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const SNAKE_VARIANT_3 = [
        C::FRAMES => [
            '⢀⠀',
            '⡀⠀',
            '⠄⠀',
            '⢂⠀',
            '⡂⠀',
            '⠅⠀',
            '⢃⠀',
            '⡃⠀',
            '⠍⠀',
            '⢋⠀',
            '⡋⠀',
            '⠍⠁',
            '⢋⠁',
            '⡋⠁',
            '⠍⠉',
            '⠋⠉',
            '⠋⠉',
            '⠉⠙',
            '⠉⠙',
            '⠉⠩',
            '⠈⢙',
            '⠈⡙',
            '⢈⠩',
            '⡀⢙',
            '⠄⡙',
            '⢂⠩',
            '⡂⢘',
            '⠅⡘',
            '⢃⠨',
            '⡃⢐',
            '⠍⡐',
            '⢋⠠',
            '⡋⢀',
            '⠍⡁',
            '⢋⠁',
            '⡋⠁',
            '⠍⠉',
            '⠋⠉',
            '⠋⠉',
            '⠉⠙',
            '⠉⠙',
            '⠉⠩',
            '⠈⢙',
            '⠈⡙',
            '⠈⠩',
            '⠀⢙',
            '⠀⡙',
            '⠀⠩',
            '⠀⢘',
            '⠀⡘',
            '⠀⠨',
            '⠀⢐',
            '⠀⡐',
            '⠀⠠',
            '⠀⢀',
            '⠀⡀',
        ],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 100
    ];

    public const DOTS_VARIANT_2 = [
        C::FRAMES => ['⢹', '⢺', '⢼', '⣸', '⣇', '⡧', '⡗', '⡏',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const DOTS_VARIANT_3 = [
        C::FRAMES => ['⢄', '⢂', '⢁', '⡁', '⡈', '⡐', '⡠'],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const DOTS_VARIANT_4 = [
        C::FRAMES => ['⠁', '⠂', '⠄', '⡀', '⢀', '⠠', '⠐', '⠈'],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const DOTS_VARIANT_5 = [
        C::FRAMES => ['   ', '.  ', '.. ', '...', ' ..', '  .', '   '],
        C::ELEMENT_WIDTH => 3,
        C::INTERVAL => 100
    ];
    public const TRIGRAM = [
        C::FRAMES => [
            '☰',        // HEAVEN
            '☱',        // LAKE
            '☲',        // FIRE
            '☴',        // WIND
            '☵',        // WATER
            '☶',        // MOUNTAIN
            '☳',        // THUNDER
            '☷',        // EARTH
        ],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const BOUNCE = [
        C::FRAMES => [
            '⠁',
            '⠂',
            '⠄',
            '⠂',
        ],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const SQUARE_VARIANT_0 = [
        C::FRAMES => [
            '◼    ',
            ' ◼   ',
            '  ◼  ',
            '   ◼ ',
            '    ◼',
            '   ◼ ',
            '  ◼  ',
            ' ◼   ',
        ],
        C::ELEMENT_WIDTH => 5,
        C::INTERVAL => 100
    ];

    public const SQUARE_VARIANT_1 = [
        C::FRAMES => [
            '▩',
            '▦',
            '▤',
            '▥',
            '▧',
            '▨',
        ],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 100
    ];

    public const BLOCK_VARIANT_0 =
        [
            C::FRAMES => [
                '▁',
                '▂',
                '▃',
                '▄',
                '▅',
                '▆',
                '▇',
                '█',
                '▉',
                '▊',
                '▋',
                '▌',
                '▍',
                '▎',
                '▏',
                '▏',
                '▎',
                '▍',
                '▌',
                '▋',
                '▊',
                '▉',
                '█',
                '▇',
                '▆',
                '▅',
                '▄',
                '▃',
                '▂',
                '▁',
            ],
            C::ELEMENT_WIDTH => 1,
            C::INTERVAL => 100
        ];

    public const BLOCK_VARIANT_1 =
        [
            C::FRAMES => [
                '▁',
                '▂',
                '▃',
                '▄',
                '▅',
                '▆',
                '▇',
                '█',
                '▇',
                '▆',
                '▅',
                '▄',
                '▃',
                '▂',
                '▁',
            ],
            C::ELEMENT_WIDTH => 1,
            C::INTERVAL => 100
        ];

    public const BLOCK_VARIANT_2 =
        [
            C::FRAMES => [
                '█',
                '▉',
                '▊',
                '▋',
                '▌',
                '▍',
                '▎',
                '▏',
                '▏',
                '▎',
                '▍',
                '▌',
                '▋',
                '▊',
                '▉',
                '█',

            ],
            C::ELEMENT_WIDTH => 1,
            C::INTERVAL => 100
        ];


    public const DICE = [
        C::FRAMES => ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 200
    ];

    public const ARROWS = [
        C::FRAMES => ['➙', '➘', '➙', '➚',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 150
    ];

    public const ARROWS_VARIANT_4 = [
        C::FRAMES => ['←', '↖', '↑', '↗', '→', '↘', '↓', '↙',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 150
    ];

    public const ARROWS_VARIANT_5 = [
        C::FRAMES => ['⇐', '⇖', '⇑', '⇗', '⇒', '⇘', '⇓', '⇙',],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 150
    ];

    public const TREE = [
        C::FRAMES => ['🌲', '🎄',],
        C::ELEMENT_WIDTH => 2,
        C::INTERVAL => 300
    ];


    public const TOGGLE_VARIANT_0 = [
        C::FRAMES => [
            '⊶',
            '⊷',
        ],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 300
    ];

    public const TOGGLE_VARIANT_1 = [
        C::FRAMES => [
            '■',
            '□',
            '▪',
            '▫',
        ],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 300
    ];

    public const BOUNCING_BAR_VARIANT_1 = [
        C::FRAMES => [
            '[    ]',
            '[=   ]',
            '[==  ]',
            '[=== ]',
            '[ ===]',
            '[  ==]',
            '[   =]',
            '[    ]',
            '[   =]',
            '[  ==]',
            '[ ===]',
            '[====]',
            '[=== ]',
            '[==  ]',
            '[=   ]',
        ],
        C::ELEMENT_WIDTH => 6,
        C::INTERVAL => 100
    ];

    public const BOUNCING_BAR_VARIANT_2 = [
        C::FRAMES => [
            '|    |',
            '|∙   |',
            '|∙∙  |',
            '|∙∙∙ |',
            '|∙∙∙∙|',
            '| ∙∙∙|',
            '|  ∙∙|',
            '|   ∙|',
            '|    |',
            '|   ∙|',
            '|  ∙∙|',
            '| ∙∙∙|',
            '|∙∙∙∙|',
            '|∙∙∙ |',
            '|∙∙  |',
            '|∙   |',
        ],
        C::ELEMENT_WIDTH => 6,
        C::INTERVAL => 100
    ];

    public const BOUNCING_BAR_VARIANT_3 = [
        C::FRAMES => [
            '|   ',
            ' |  ',
            '  | ',
            '   |',
            '   |',
            '  | ',
            ' |  ',
            '|   ',
        ],
        C::ELEMENT_WIDTH => 4,
        C::INTERVAL => 100
    ];

    public const
        FEATHERED_ARROWS =
        [
            C::FRAMES => [
                '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
                '➴', // BLACK-FEATHERED SOUTH EAST ARROW
                '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
                '➶', // BLACK-FEATHERED NORTH EAST ARROW
                '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
                '➷', // HEAVY BLACK-FEATHERED SOUTH EAST ARROW
                '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
                '➹', // HEAVY BLACK-FEATHERED NORTH EAST ARROW
            ],
            C::ELEMENT_WIDTH => 1,
            C::INTERVAL => 150
        ];

    public const DOT_8_BIT = [
        C::FRAMES => [
            "⠀",
            "⠁",
            "⠂",
            "⠃",
            "⠄",
            "⠅",
            "⠆",
            "⠇",
            "⡀",
            "⡁",
            "⡂",
            "⡃",
            "⡄",
            "⡅",
            "⡆",
            "⡇",
            "⠈",
            "⠉",
            "⠊",
            "⠋",
            "⠌",
            "⠍",
            "⠎",
            "⠏",
            "⡈",
            "⡉",
            "⡊",
            "⡋",
            "⡌",
            "⡍",
            "⡎",
            "⡏",
            "⠐",
            "⠑",
            "⠒",
            "⠓",
            "⠔",
            "⠕",
            "⠖",
            "⠗",
            "⡐",
            "⡑",
            "⡒",
            "⡓",
            "⡔",
            "⡕",
            "⡖",
            "⡗",
            "⠘",
            "⠙",
            "⠚",
            "⠛",
            "⠜",
            "⠝",
            "⠞",
            "⠟",
            "⡘",
            "⡙",
            "⡚",
            "⡛",
            "⡜",
            "⡝",
            "⡞",
            "⡟",
            "⠠",
            "⠡",
            "⠢",
            "⠣",
            "⠤",
            "⠥",
            "⠦",
            "⠧",
            "⡠",
            "⡡",
            "⡢",
            "⡣",
            "⡤",
            "⡥",
            "⡦",
            "⡧",
            "⠨",
            "⠩",
            "⠪",
            "⠫",
            "⠬",
            "⠭",
            "⠮",
            "⠯",
            "⡨",
            "⡩",
            "⡪",
            "⡫",
            "⡬",
            "⡭",
            "⡮",
            "⡯",
            "⠰",
            "⠱",
            "⠲",
            "⠳",
            "⠴",
            "⠵",
            "⠶",
            "⠷",
            "⡰",
            "⡱",
            "⡲",
            "⡳",
            "⡴",
            "⡵",
            "⡶",
            "⡷",
            "⠸",
            "⠹",
            "⠺",
            "⠻",
            "⠼",
            "⠽",
            "⠾",
            "⠿",
            "⡸",
            "⡹",
            "⡺",
            "⡻",
            "⡼",
            "⡽",
            "⡾",
            "⡿",
            "⢀",
            "⢁",
            "⢂",
            "⢃",
            "⢄",
            "⢅",
            "⢆",
            "⢇",
            "⣀",
            "⣁",
            "⣂",
            "⣃",
            "⣄",
            "⣅",
            "⣆",
            "⣇",
            "⢈",
            "⢉",
            "⢊",
            "⢋",
            "⢌",
            "⢍",
            "⢎",
            "⢏",
            "⣈",
            "⣉",
            "⣊",
            "⣋",
            "⣌",
            "⣍",
            "⣎",
            "⣏",
            "⢐",
            "⢑",
            "⢒",
            "⢓",
            "⢔",
            "⢕",
            "⢖",
            "⢗",
            "⣐",
            "⣑",
            "⣒",
            "⣓",
            "⣔",
            "⣕",
            "⣖",
            "⣗",
            "⢘",
            "⢙",
            "⢚",
            "⢛",
            "⢜",
            "⢝",
            "⢞",
            "⢟",
            "⣘",
            "⣙",
            "⣚",
            "⣛",
            "⣜",
            "⣝",
            "⣞",
            "⣟",
            "⢠",
            "⢡",
            "⢢",
            "⢣",
            "⢤",
            "⢥",
            "⢦",
            "⢧",
            "⣠",
            "⣡",
            "⣢",
            "⣣",
            "⣤",
            "⣥",
            "⣦",
            "⣧",
            "⢨",
            "⢩",
            "⢪",
            "⢫",
            "⢬",
            "⢭",
            "⢮",
            "⢯",
            "⣨",
            "⣩",
            "⣪",
            "⣫",
            "⣬",
            "⣭",
            "⣮",
            "⣯",
            "⢰",
            "⢱",
            "⢲",
            "⢳",
            "⢴",
            "⢵",
            "⢶",
            "⢷",
            "⣰",
            "⣱",
            "⣲",
            "⣳",
            "⣴",
            "⣵",
            "⣶",
            "⣷",
            "⢸",
            "⢹",
            "⢺",
            "⢻",
            "⢼",
            "⢽",
            "⢾",
            "⢿",
            "⣸",
            "⣹",
            "⣺",
            "⣻",
            "⣼",
            "⣽",
            "⣾",
            "⣿"
        ],
        C::ELEMENT_WIDTH => 1,
        C::INTERVAL => 1000
    ];

    private function __construct()
    {
    }

}
