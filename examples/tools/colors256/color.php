<?php

use AlecRabbit\ConsoleColour\ConsoleColor;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../data.php';

$c = new ConsoleColor();

$arranged = arrange($decoded);
//dump($arranged);
foreach ($arranged as $key => $segment) {
    echo $key . PHP_EOL;
    usort(
        $segment,
        static function ($a, $b) {
            if ($a['hsl']['h'] === $b['hsl']['h']) {
                return 0;
            }
            return ($a['hsl']['h'] < $b['hsl']['h']) ? -1 : 1;
        });
    foreach ($segment as $item) {
        showColor($c, $item);
    }
}

// ******************************* F *******************************
function arrange($decoded): array
{
    $result = [];
    foreach ($decoded as $colorNum => $item) {
        $hsl = $item['hsl'];
        $key = $hsl['s'] . '.' . $hsl['l'];
        $result[$key][] = $item;
    }
    return $result;
}

function showColor(ConsoleColor $c, $item): void
{
    //[
    //  "colorId" => 253
    //  "hexString" => "#dadada"
    //  "rgb" => array:3 [
    //    "r" => 218
    //    "g" => 218
    //    "b" => 218
    //  ]
    //  "hsl" => array:3 [
    //    "h" => 0
    //    "s" => 0
    //    "l" => 85
    //  ]
    //  "name" => "Grey85"
    //]

    echo $c->apply('bg_color_' . $item['colorId'], '    ') . ' ' . $item['colorId'] . ' ' . $item['name'] . PHP_EOL;
}

//     160 Red3
//     166 DarkOrange3
//     172 Orange3
//     178 Gold3
//     184 Yellow3
//     148 Yellow3
//     112 Chartreuse2
//     76 Chartreuse3
//     40 Green3
//     41 SpringGreen3
//     42 SpringGreen2
//     43 Cyan3
//     44 DarkTurquoise
//     38 DeepSkyBlue2
//     32 DeepSkyBlue3
//     26 DodgerBlue3
//     20 Blue3
//     56 Purple3
//     92 DarkViolet
//     128 DarkViolet
//     164 Magenta3
//     163 Magenta3
//     162 DeepPink3
//     161 DeepPink3


//     203 IndianRed1
//     209 Salmon1
//     215 SandyBrown
//     221 LightGoldenrod2
//     227 LightGoldenrod1
//     191 DarkOliveGreen1
//     155 DarkOliveGreen2
//     119 LightGreen
//     83 SeaGreen2
//     84 SeaGreen1
//     85 SeaGreen1
//     86 Aquamarine1
//     87 DarkSlateGray2
//     81 SteelBlue1
//     75 SteelBlue1
//     69 CornflowerBlue
//     63 RoyalBlue1
//     99 SlateBlue1
//     135 MediumPurple2
//     171 MediumOrchid1
//     207 MediumOrchid1
//     206 HotPink
//     205 HotPink
//     204 IndianRed1