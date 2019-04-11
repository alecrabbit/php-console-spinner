<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Contracts;

/**
 * If you can't see any symbols doesn't mean they're not there!
 * They ARE!
 */
interface SpinnerSymbols
{
    public const CIRCLES = ['◐', '◓', '◑', '◒',];

    public const CLOCK = ['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',];
    public const CLOCK_VARIANT = ['🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦',];

    public const MOON = ['🌘', '🌗', '🌖', '🌕', '🌔', '🌓', '🌒', '🌑',];
    public const MOON_REVERSED = ['🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘',];

    public const BASE = ['/', '|', '\\', '─',];

    public const SIMPLE = ['◴', '◷', '◶', '◵'];

    public const SNAKE = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];

    public const DICE = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅',];

    public const
        ZODIAC =
        [
            '♈', // ARIES
            '♉', // TAURUS
            '♊', // GEMINI
            '♋', // CANCER
            '♌', // LEO
            '♍', // VIRGO
            '♎', // LIBRA
            '♏', // SCORPIUS
            '♐', // SAGITTARIUS
            '♑', // CAPRICORN
            '♒', // AQUARIUS
            '♓', // PISCES
        ];

    // U+2800  '⠀'  BRAILLE PATTERN BLANK
    // U+2801  '⠁'  BRAILLE PATTERN DOTS-1
    // U+2802  '⠂'  BRAILLE PATTERN DOTS-2
    // U+2803  '⠃'  BRAILLE PATTERN DOTS-12
    // U+2804  '⠄'  BRAILLE PATTERN DOTS-3
    // U+2805  '⠅'  BRAILLE PATTERN DOTS-13
    // U+2806  '⠆'  BRAILLE PATTERN DOTS-23
    // U+2807  '⠇'  BRAILLE PATTERN DOTS-123
    // U+2808  '⠈'  BRAILLE PATTERN DOTS-4
    // U+2809  '⠉'  BRAILLE PATTERN DOTS-14
    // U+280A  '⠊'  BRAILLE PATTERN DOTS-24
    // U+280B  '⠋'  BRAILLE PATTERN DOTS-124
    // U+280C  '⠌'  BRAILLE PATTERN DOTS-34
    // U+280D  '⠍'  BRAILLE PATTERN DOTS-134
    // U+280E  '⠎'  BRAILLE PATTERN DOTS-234
    // U+280F  '⠏'  BRAILLE PATTERN DOTS-1234
    // U+2810  '⠐'  BRAILLE PATTERN DOTS-5
    // U+2811  '⠑'  BRAILLE PATTERN DOTS-15
    // U+2812  '⠒'  BRAILLE PATTERN DOTS-25
    // U+2813  '⠓'  BRAILLE PATTERN DOTS-125
    // U+2814  '⠔'  BRAILLE PATTERN DOTS-35
    // U+2815  '⠕'  BRAILLE PATTERN DOTS-135
    // U+2816  '⠖'  BRAILLE PATTERN DOTS-235
    // U+2817  '⠗'  BRAILLE PATTERN DOTS-1235
    // U+2818  '⠘'  BRAILLE PATTERN DOTS-45
    // U+2819  '⠙'  BRAILLE PATTERN DOTS-145
    // U+281A  '⠚'  BRAILLE PATTERN DOTS-245
    // U+281B  '⠛'  BRAILLE PATTERN DOTS-1245
    // U+281C  '⠜'  BRAILLE PATTERN DOTS-345
    // U+281D  '⠝'  BRAILLE PATTERN DOTS-1345
    // U+281E  '⠞'  BRAILLE PATTERN DOTS-2345
    // U+281F  '⠟'  BRAILLE PATTERN DOTS-12345
    // U+2820  '⠠'  BRAILLE PATTERN DOTS-6
    // U+2821  '⠡'  BRAILLE PATTERN DOTS-16
    // U+2822  '⠢'  BRAILLE PATTERN DOTS-26
    // U+2823  '⠣'  BRAILLE PATTERN DOTS-126
    // U+2824  '⠤'  BRAILLE PATTERN DOTS-36
    // U+2825  '⠥'  BRAILLE PATTERN DOTS-136
    // U+2826  '⠦'  BRAILLE PATTERN DOTS-236
    // U+2827  '⠧'  BRAILLE PATTERN DOTS-1236
    // U+2828  '⠨'  BRAILLE PATTERN DOTS-46
    // U+2829  '⠩'  BRAILLE PATTERN DOTS-146
    // U+282A  '⠪'  BRAILLE PATTERN DOTS-246
    // U+282B  '⠫'  BRAILLE PATTERN DOTS-1246
    // U+282C  '⠬'  BRAILLE PATTERN DOTS-346
    // U+282D  '⠭'  BRAILLE PATTERN DOTS-1346
    // U+282E  '⠮'  BRAILLE PATTERN DOTS-2346
    // U+282F  '⠯'  BRAILLE PATTERN DOTS-12346
    // U+2830  '⠰'  BRAILLE PATTERN DOTS-56
    // U+2831  '⠱'  BRAILLE PATTERN DOTS-156
    // U+2832  '⠲'  BRAILLE PATTERN DOTS-256
    // U+2833  '⠳'  BRAILLE PATTERN DOTS-1256
    // U+2834  '⠴'  BRAILLE PATTERN DOTS-356
    // U+2835  '⠵'  BRAILLE PATTERN DOTS-1356
    // U+2836  '⠶'  BRAILLE PATTERN DOTS-2356
    // U+2837  '⠷'  BRAILLE PATTERN DOTS-12356
    // U+2838  '⠸'  BRAILLE PATTERN DOTS-456
    // U+2839  '⠹'  BRAILLE PATTERN DOTS-1456
    // U+283A  '⠺'  BRAILLE PATTERN DOTS-2456
    // U+283B  '⠻'  BRAILLE PATTERN DOTS-12456
    // U+283C  '⠼'  BRAILLE PATTERN DOTS-3456
    // U+283D  '⠽'  BRAILLE PATTERN DOTS-13456
    // U+283E  '⠾'  BRAILLE PATTERN DOTS-23456
    // U+283F  '⠿'  BRAILLE PATTERN DOTS-123456
    // U+2840  '⡀'  BRAILLE PATTERN DOTS-7
    // U+2841  '⡁'  BRAILLE PATTERN DOTS-17
    // U+2842  '⡂'  BRAILLE PATTERN DOTS-27
    // U+2843  '⡃'  BRAILLE PATTERN DOTS-127
    // U+2844  '⡄'  BRAILLE PATTERN DOTS-37
    // U+2845  '⡅'  BRAILLE PATTERN DOTS-137
    // U+2846  '⡆'  BRAILLE PATTERN DOTS-237
    // U+2847  '⡇'  BRAILLE PATTERN DOTS-1237
    // U+2848  '⡈'  BRAILLE PATTERN DOTS-47
    // U+2849  '⡉'  BRAILLE PATTERN DOTS-147
    // U+284A  '⡊'  BRAILLE PATTERN DOTS-247
    // U+284B  '⡋'  BRAILLE PATTERN DOTS-1247
    // U+284C  '⡌'  BRAILLE PATTERN DOTS-347
    // U+284D  '⡍'  BRAILLE PATTERN DOTS-1347
    // U+284E  '⡎'  BRAILLE PATTERN DOTS-2347
    // U+284F  '⡏'  BRAILLE PATTERN DOTS-12347
    // U+2850  '⡐'  BRAILLE PATTERN DOTS-57
    // U+2851  '⡑'  BRAILLE PATTERN DOTS-157
    // U+2852  '⡒'  BRAILLE PATTERN DOTS-257
    // U+2853  '⡓'  BRAILLE PATTERN DOTS-1257
    // U+2854  '⡔'  BRAILLE PATTERN DOTS-357
    // U+2855  '⡕'  BRAILLE PATTERN DOTS-1357
    // U+2856  '⡖'  BRAILLE PATTERN DOTS-2357
    // U+2857  '⡗'  BRAILLE PATTERN DOTS-12357
    // U+2858  '⡘'  BRAILLE PATTERN DOTS-457
    // U+2859  '⡙'  BRAILLE PATTERN DOTS-1457
    // U+285A  '⡚'  BRAILLE PATTERN DOTS-2457
    // U+285B  '⡛'  BRAILLE PATTERN DOTS-12457
    // U+285C  '⡜'  BRAILLE PATTERN DOTS-3457
    // U+285D  '⡝'  BRAILLE PATTERN DOTS-13457
    // U+285E  '⡞'  BRAILLE PATTERN DOTS-23457
    // U+285F  '⡟'  BRAILLE PATTERN DOTS-123457
    // U+2860  '⡠'  BRAILLE PATTERN DOTS-67
    // U+2861  '⡡'  BRAILLE PATTERN DOTS-167
    // U+2862  '⡢'  BRAILLE PATTERN DOTS-267
    // U+2863  '⡣'  BRAILLE PATTERN DOTS-1267
    // U+2864  '⡤'  BRAILLE PATTERN DOTS-367
    // U+2865  '⡥'  BRAILLE PATTERN DOTS-1367
    // U+2866  '⡦'  BRAILLE PATTERN DOTS-2367
    // U+2867  '⡧'  BRAILLE PATTERN DOTS-12367
    // U+2868  '⡨'  BRAILLE PATTERN DOTS-467
    // U+2869  '⡩'  BRAILLE PATTERN DOTS-1467
    // U+286A  '⡪'  BRAILLE PATTERN DOTS-2467
    // U+286B  '⡫'  BRAILLE PATTERN DOTS-12467
    // U+286C  '⡬'  BRAILLE PATTERN DOTS-3467
    // U+286D  '⡭'  BRAILLE PATTERN DOTS-13467
    // U+286E  '⡮'  BRAILLE PATTERN DOTS-23467
    // U+286F  '⡯'  BRAILLE PATTERN DOTS-123467
    // U+2870  '⡰'  BRAILLE PATTERN DOTS-567
    // U+2871  '⡱'  BRAILLE PATTERN DOTS-1567
    // U+2872  '⡲'  BRAILLE PATTERN DOTS-2567
    // U+2873  '⡳'  BRAILLE PATTERN DOTS-12567
    // U+2874  '⡴'  BRAILLE PATTERN DOTS-3567
    // U+2875  '⡵'  BRAILLE PATTERN DOTS-13567
    // U+2876  '⡶'  BRAILLE PATTERN DOTS-23567
    // U+2877  '⡷'  BRAILLE PATTERN DOTS-123567
    // U+2878  '⡸'  BRAILLE PATTERN DOTS-4567
    // U+2879  '⡹'  BRAILLE PATTERN DOTS-14567
    // U+287A  '⡺'  BRAILLE PATTERN DOTS-24567
    // U+287B  '⡻'  BRAILLE PATTERN DOTS-124567
    // U+287C  '⡼'  BRAILLE PATTERN DOTS-34567
    // U+287D  '⡽'  BRAILLE PATTERN DOTS-134567
    // U+287E  '⡾'  BRAILLE PATTERN DOTS-234567
    // U+287F  '⡿'  BRAILLE PATTERN DOTS-1234567
    // U+2880  '⢀'  BRAILLE PATTERN DOTS-8
    // U+2881  '⢁'  BRAILLE PATTERN DOTS-18
    // U+2882  '⢂'  BRAILLE PATTERN DOTS-28
    // U+2883  '⢃'  BRAILLE PATTERN DOTS-128
    // U+2884  '⢄'  BRAILLE PATTERN DOTS-38
    // U+2885  '⢅'  BRAILLE PATTERN DOTS-138
    // U+2886  '⢆'  BRAILLE PATTERN DOTS-238
    // U+2887  '⢇'  BRAILLE PATTERN DOTS-1238
    // U+2888  '⢈'  BRAILLE PATTERN DOTS-48
    // U+2889  '⢉'  BRAILLE PATTERN DOTS-148
    // U+288A  '⢊'  BRAILLE PATTERN DOTS-248
    // U+288B  '⢋'  BRAILLE PATTERN DOTS-1248
    // U+288C  '⢌'  BRAILLE PATTERN DOTS-348
    // U+288D  '⢍'  BRAILLE PATTERN DOTS-1348
    // U+288E  '⢎'  BRAILLE PATTERN DOTS-2348
    // U+288F  '⢏'  BRAILLE PATTERN DOTS-12348
    // U+2890  '⢐'  BRAILLE PATTERN DOTS-58
    // U+2891  '⢑'  BRAILLE PATTERN DOTS-158
    // U+2892  '⢒'  BRAILLE PATTERN DOTS-258
    // U+2893  '⢓'  BRAILLE PATTERN DOTS-1258
    // U+2894  '⢔'  BRAILLE PATTERN DOTS-358
    // U+2895  '⢕'  BRAILLE PATTERN DOTS-1358
    // U+2896  '⢖'  BRAILLE PATTERN DOTS-2358
    // U+2897  '⢗'  BRAILLE PATTERN DOTS-12358
    // U+2898  '⢘'  BRAILLE PATTERN DOTS-458
    // U+2899  '⢙'  BRAILLE PATTERN DOTS-1458
    // U+289A  '⢚'  BRAILLE PATTERN DOTS-2458
    // U+289B  '⢛'  BRAILLE PATTERN DOTS-12458
    // U+289C  '⢜'  BRAILLE PATTERN DOTS-3458
    // U+289D  '⢝'  BRAILLE PATTERN DOTS-13458
    // U+289E  '⢞'  BRAILLE PATTERN DOTS-23458
    // U+289F  '⢟'  BRAILLE PATTERN DOTS-123458
    // U+28A0  '⢠'  BRAILLE PATTERN DOTS-68
    // U+28A1  '⢡'  BRAILLE PATTERN DOTS-168
    // U+28A2  '⢢'  BRAILLE PATTERN DOTS-268
    // U+28A3  '⢣'  BRAILLE PATTERN DOTS-1268
    // U+28A4  '⢤'  BRAILLE PATTERN DOTS-368
    // U+28A5  '⢥'  BRAILLE PATTERN DOTS-1368
    // U+28A6  '⢦'  BRAILLE PATTERN DOTS-2368
    // U+28A7  '⢧'  BRAILLE PATTERN DOTS-12368
    // U+28A8  '⢨'  BRAILLE PATTERN DOTS-468
    // U+28A9  '⢩'  BRAILLE PATTERN DOTS-1468
    // U+28AA  '⢪'  BRAILLE PATTERN DOTS-2468
    // U+28AB  '⢫'  BRAILLE PATTERN DOTS-12468
    // U+28AC  '⢬'  BRAILLE PATTERN DOTS-3468
    // U+28AD  '⢭'  BRAILLE PATTERN DOTS-13468
    // U+28AE  '⢮'  BRAILLE PATTERN DOTS-23468
    // U+28AF  '⢯'  BRAILLE PATTERN DOTS-123468
    // U+28B0  '⢰'  BRAILLE PATTERN DOTS-568
    // U+28B1  '⢱'  BRAILLE PATTERN DOTS-1568
    // U+28B2  '⢲'  BRAILLE PATTERN DOTS-2568
    // U+28B3  '⢳'  BRAILLE PATTERN DOTS-12568
    // U+28B4  '⢴'  BRAILLE PATTERN DOTS-3568
    // U+28B5  '⢵'  BRAILLE PATTERN DOTS-13568
    // U+28B6  '⢶'  BRAILLE PATTERN DOTS-23568
    // U+28B7  '⢷'  BRAILLE PATTERN DOTS-123568
    // U+28B8  '⢸'  BRAILLE PATTERN DOTS-4568
    // U+28B9  '⢹'  BRAILLE PATTERN DOTS-14568
    // U+28BA  '⢺'  BRAILLE PATTERN DOTS-24568
    // U+28BB  '⢻'  BRAILLE PATTERN DOTS-124568
    // U+28BC  '⢼'  BRAILLE PATTERN DOTS-34568
    // U+28BD  '⢽'  BRAILLE PATTERN DOTS-134568
    // U+28BE  '⢾'  BRAILLE PATTERN DOTS-234568
    // U+28BF  '⢿'  BRAILLE PATTERN DOTS-1234568
    // U+28C0  '⣀'  BRAILLE PATTERN DOTS-78
    // U+28C1  '⣁'  BRAILLE PATTERN DOTS-178
    // U+28C2  '⣂'  BRAILLE PATTERN DOTS-278
    // U+28C3  '⣃'  BRAILLE PATTERN DOTS-1278
    // U+28C4  '⣄'  BRAILLE PATTERN DOTS-378
    // U+28C5  '⣅'  BRAILLE PATTERN DOTS-1378
    // U+28C6  '⣆'  BRAILLE PATTERN DOTS-2378
    // U+28C7  '⣇'  BRAILLE PATTERN DOTS-12378
    // U+28C8  '⣈'  BRAILLE PATTERN DOTS-478
    // U+28C9  '⣉'  BRAILLE PATTERN DOTS-1478
    // U+28CA  '⣊'  BRAILLE PATTERN DOTS-2478
    // U+28CB  '⣋'  BRAILLE PATTERN DOTS-12478
    // U+28CC  '⣌'  BRAILLE PATTERN DOTS-3478
    // U+28CD  '⣍'  BRAILLE PATTERN DOTS-13478
    // U+28CE  '⣎'  BRAILLE PATTERN DOTS-23478
    // U+28CF  '⣏'  BRAILLE PATTERN DOTS-123478
    // U+28D0  '⣐'  BRAILLE PATTERN DOTS-578
    // U+28D1  '⣑'  BRAILLE PATTERN DOTS-1578
    // U+28D2  '⣒'  BRAILLE PATTERN DOTS-2578
    // U+28D3  '⣓'  BRAILLE PATTERN DOTS-12578
    // U+28D4  '⣔'  BRAILLE PATTERN DOTS-3578
    // U+28D5  '⣕'  BRAILLE PATTERN DOTS-13578
    // U+28D6  '⣖'  BRAILLE PATTERN DOTS-23578
    // U+28D7  '⣗'  BRAILLE PATTERN DOTS-123578
    // U+28D8  '⣘'  BRAILLE PATTERN DOTS-4578
    // U+28D9  '⣙'  BRAILLE PATTERN DOTS-14578
    // U+28DA  '⣚'  BRAILLE PATTERN DOTS-24578
    // U+28DB  '⣛'  BRAILLE PATTERN DOTS-124578
    // U+28DC  '⣜'  BRAILLE PATTERN DOTS-34578
    // U+28DD  '⣝'  BRAILLE PATTERN DOTS-134578
    // U+28DE  '⣞'  BRAILLE PATTERN DOTS-234578
    // U+28DF  '⣟'  BRAILLE PATTERN DOTS-1234578
    // U+28E0  '⣠'  BRAILLE PATTERN DOTS-678
    // U+28E1  '⣡'  BRAILLE PATTERN DOTS-1678
    // U+28E2  '⣢'  BRAILLE PATTERN DOTS-2678
    // U+28E3  '⣣'  BRAILLE PATTERN DOTS-12678
    // U+28E4  '⣤'  BRAILLE PATTERN DOTS-3678
    // U+28E5  '⣥'  BRAILLE PATTERN DOTS-13678
    // U+28E6  '⣦'  BRAILLE PATTERN DOTS-23678
    // U+28E7  '⣧'  BRAILLE PATTERN DOTS-123678
    // U+28E8  '⣨'  BRAILLE PATTERN DOTS-4678
    // U+28E9  '⣩'  BRAILLE PATTERN DOTS-14678
    // U+28EA  '⣪'  BRAILLE PATTERN DOTS-24678
    // U+28EB  '⣫'  BRAILLE PATTERN DOTS-124678
    // U+28EC  '⣬'  BRAILLE PATTERN DOTS-34678
    // U+28ED  '⣭'  BRAILLE PATTERN DOTS-134678
    // U+28EE  '⣮'  BRAILLE PATTERN DOTS-234678
    // U+28EF  '⣯'  BRAILLE PATTERN DOTS-1234678
    // U+28F0  '⣰'  BRAILLE PATTERN DOTS-5678
    // U+28F1  '⣱'  BRAILLE PATTERN DOTS-15678
    // U+28F2  '⣲'  BRAILLE PATTERN DOTS-25678
    // U+28F3  '⣳'  BRAILLE PATTERN DOTS-125678
    // U+28F4  '⣴'  BRAILLE PATTERN DOTS-35678
    // U+28F5  '⣵'  BRAILLE PATTERN DOTS-135678
    // U+28F6  '⣶'  BRAILLE PATTERN DOTS-235678
    // U+28F7  '⣷'  BRAILLE PATTERN DOTS-1235678
    // U+28F8  '⣸'  BRAILLE PATTERN DOTS-45678
    // U+28F9  '⣹'  BRAILLE PATTERN DOTS-145678
    // U+28FA  '⣺'  BRAILLE PATTERN DOTS-245678
    // U+28FB  '⣻'  BRAILLE PATTERN DOTS-1245678
    // U+28FC  '⣼'  BRAILLE PATTERN DOTS-345678
    // U+28FD  '⣽'  BRAILLE PATTERN DOTS-1345678
    // U+28FE  '⣾'  BRAILLE PATTERN DOTS-2345678
    // U+28FF  '⣿'  BRAILLE PATTERN DOTS-12345678
}
