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

    public const CIRCLES = [['◐', '◓', '◑', '◒',], 1, 250];
    public const RUNNER = [['🚶 ', '🏃 '], 3, 400];
    public const MONKEY = [['🐵 ', '🙈 ', '🙉 ', '🙊 '], 3, 300];

    public const SECTOR = [['◴ ', '◷ ', '◶ ', '◵ '], 2, 250];

    public const CLOCK_VARIANT_0 = [['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',], 2, 150];
    public const CLOCK_VARIANT_1 = [['🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦',], 2, 150];

    public const CLOCK_VARIANT_2 = [
        [
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
        2,
        150
    ];

    public const DOT = [['⢀', '⡀', '⠄', '⠂', '⠁', '⠈', '⠐', '⠠',], 1];
    public const DOT_REVERSED = [['⠠', '⠐', '⠈', '⠁', '⠂', '⠄', '⡀', '⢀',], 1];

    public const ARROW_VARIANT_0 = [
        [
            '▹▹▹▹▹',
            '▸▹▹▹▹',
            '▹▸▹▹▹',
            '▹▹▸▹▹',
            '▹▹▹▸▹',
            '▹▹▹▹▸',
        ],
        5
    ];

    public const ARROW_VARIANT_1 = [
        [
            '◁ ◁ ◁ ◁ ◀',
            '◁ ◁ ◁ ◀ ◁',
            '◁ ◁ ◀ ◁ ◁',
            '◁ ◀ ◁ ◁ ◁',
            '◀ ◁ ◁ ◁ ◁',
        ],
        9
    ];

    public const ARROW_VARIANT_2 = [
        [
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
        5
    ];

    public const ARROW_VARIANT_3 = [
        [
            '◃◃◃◃◃',
            '◃◃◃◃◂',
            '◃◃◃◂◃',
            '◃◃◂◃◃',
            '◃◂◃◃◃',
            '◂◃◃◃◃',
        ],
        5
    ];

    public const WEATHER_VARIANT_0 = [
        [
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
        2,
        150
    ];


    public const WEATHER_VARIANT_1 = [
        [
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
        2
    ];

    public const BALL_VARIANT_0 = [
        [
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
        8
    ];

    public const SNAKE_VARIANT_0 = [['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇',], 1, 100];
    public const SNAKE_VARIANT_1 = [['⣇', '⡏', '⠟', '⠻', '⢹', '⣸', '⣴', '⣦',], 1];
    public const SNAKE_VARIANT_2 = [['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'], 1, 100];
    public const SNAKE_VARIANT_3 = [
        [
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
        2,
        100
    ];

    public const DOTS_VARIANT_2 = [['⢹', '⢺', '⢼', '⣸', '⣇', '⡧', '⡗', '⡏',], 1, 100];
    public const DOTS_VARIANT_3 = [['⢄', '⢂', '⢁', '⡁', '⡈', '⡐', '⡠'], 1, 100];
    public const DOTS_VARIANT_4 = [['⠁', '⠂', '⠄', '⡀', '⢀', '⠠', '⠐', '⠈'], 1, 100];
    public const DOTS_VARIANT_5 = [['   ', '.  ', '.. ', '...', ' ..', '  .', '   '], 3, 100];
    public const TRIGRAM = [
        [
            '☰',        // HEAVEN
            '☱',        // LAKE
            '☲',        // FIRE
            '☴',        // WIND
            '☵',        // WATER
            '☶',        // MOUNTAIN
            '☳',        // THUNDER
            '☷',        // EARTH
        ],
        1,
        100
    ];

    public const BOUNCE = [
        [
            '⠁',
            '⠂',
            '⠄',
            '⠂',
        ],
        1,
        100
    ];

    public const SQUARE_VARIANT_0 = [
        [
            '◼    ',
            ' ◼   ',
            '  ◼  ',
            '   ◼ ',
            '    ◼',
            '   ◼ ',
            '  ◼  ',
            ' ◼   ',
        ],
        5,
        100
    ];

    public const SQUARE_VARIANT_1 = [
        [
            '▩',
            '▦',
            '▤',
            '▥',
            '▧',
            '▨',
        ],
        1,
        100
    ];

    public const BLOCK_VARIANT_0 =
        [
            [
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
            1,
            100
        ];

    public const BLOCK_VARIANT_1 =
        [
            [
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
            1,
            100
        ];
    public const BLOCK_VARIANT_2 =
        [
            [
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
            1,
            100
        ];


    public const DICE = [['⚀', '⚁', '⚂', '⚃', '⚄', '⚅',], 1, 200];

    public const ARROWS = [['➙', '➘', '➙', '➚',], 1, 150];
    public const ARROWS_VARIANT_4 = [['←', '↖', '↑', '↗', '→', '↘', '↓', '↙',], 1, 150];
    public const ARROWS_VARIANT_5 = [['⇐', '⇖', '⇑', '⇗', '⇒', '⇘', '⇓', '⇙',], 1, 150];
    public const TREE = [['🌲', '🎄',], 2, 300];


    public const TOGGLE_VARIANT_0 = [
        [
            '⊶',
            '⊷',
        ],
        1,
        300
    ];

    public const TOGGLE_VARIANT_1 = [
        [
            '■',
            '□',
            '▪',
            '▫',
        ],
        1,
        300
    ];

    public const BOUNCING_BAR_VARIANT_1 = [
        [
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
        6,
        100
    ];

    public const BOUNCING_BAR_VARIANT_2 = [
        [
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
        6,
        100
    ];

    public const BOUNCING_BAR_VARIANT_3 = [
        [
            '|   ',
            ' |  ',
            '  | ',
            '   |',
            '   |',
            '  | ',
            ' |  ',
            '|   ',
        ],
        4,
        100
    ];

    public const
        FEATHERED_ARROWS =
        [
            [
                '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
                '➴', // BLACK-FEATHERED SOUTH EAST ARROW
                '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
                '➶', // BLACK-FEATHERED NORTH EAST ARROW
                '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
                '➷', // HEAVY BLACK-FEATHERED SOUTH EAST ARROW
                '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
                '➹', // HEAVY BLACK-FEATHERED NORTH EAST ARROW
            ],
            1,
            150
        ];

    public const DOT_8_BIT = [
        [
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
        1,
        1000
    ];
    public const FRAMES = 'frames';
    public const ELEMENT_WIDTH = 'elementWidth';

    private function __construct()
    {
    }

}
