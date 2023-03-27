<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class Rainbow extends AStylePattern
{
    protected const UPDATE_INTERVAL = 100;

    /** @inheritdoc */
    protected function extractPattern(): array
    {
        return
            match ($this->styleMode) {
                StyleMode::ANSI4 => [
                    '#00ffff', // light cyan
                ],
                StyleMode::ANSI8 => [
                    '#ff0000', // 196
                    '#ff8700', // 208
                    '#ffaf00', // 214
                    '#ffd700', // 220
                    '#ffff00', // 226
                    '#d7ff00', // 190
                    '#afff00', // 154
                    '#87ff00', // 118
                    '#5fff00', // 82
                    '#00ff00', // 46
                    '#00ff5f', // 47
                    '#00ff87', // 48
                    '#00ffaf', // 49
                    '#00ffd7', // 50
                    '#00ffff', // 51
                    '#00d7ff', // 45
                    '#00afff', // 39
                    '#0087ff', // 33
                    '#005fff', // 27
                    '#5f00d7', // 56
                    '#5f00ff', // 57
                    '#8700ff', // 93
                    '#af00ff', // 129
                    '#d700ff', // 165
                    '#ff00ff', // 201
                    '#ff00d7', // 200
                    '#ff00af', // 199
                    '#ff0087', // 198
                    '#ff005f', // 197
                ],
                StyleMode::ANSI24 => [
                    '#ff0000',
                    '#ff0400',
                    '#ff0800',
                    '#ff0c00',
                    '#ff1000',
                    '#ff1500',
                    '#ff1900',
                    '#ff1d00',
                    '#ff2100',
                    '#ff2600',
                    '#ff2a00',
                    '#ff2e00',
                    '#ff3200',
                    '#ff3700',
                    '#ff3b00',
                    '#ff3f00',
                    '#ff4300',
                    '#ff4800',
                    '#ff4c00',
                    '#ff5000',
                    '#ff5400',
                    '#ff5900',
                    '#ff5d00',
                    '#ff6100',
                    '#ff6600',
                    '#ff6a00',
                    '#ff6e00',
                    '#ff7200',
                    '#ff7700',
                    '#ff7b00',
                    '#ff7f00',
                    '#ff8300',
                    '#ff8800',
                    '#ff8c00',
                    '#ff9000',
                    '#ff9400',
                    '#ff9900',
                    '#ff9d00',
                    '#ffa100',
                    '#ffa500',
                    '#ffaa00',
                    '#ffae00',
                    '#ffb200',
                    '#ffb600',
                    '#ffbb00',
                    '#ffbf00',
                    '#ffc300',
                    '#ffc700',
                    '#ffcc00',
                    '#ffd000',
                    '#ffd400',
                    '#ffd800',
                    '#ffdc00',
                    '#ffe100',
                    '#ffe500',
                    '#ffe900',
                    '#ffee00',
                    '#fff200',
                    '#fff600',
                    '#fffa00',
                    '#ffff00',
                    '#faff00',
                    '#f6ff00',
                    '#f2ff00',
                    '#eeff00',
                    '#e9ff00',
                    '#e5ff00',
                    '#e1ff00',
                    '#ddff00',
                    '#d8ff00',
                    '#d4ff00',
                    '#d0ff00',
                    '#cbff00',
                    '#c7ff00',
                    '#c3ff00',
                    '#bfff00',
                    '#bbff00',
                    '#b6ff00',
                    '#b2ff00',
                    '#aeff00',
                    '#aaff00',
                    '#a5ff00',
                    '#a1ff00',
                    '#9dff00',
                    '#99ff00',
                    '#94ff00',
                    '#90ff00',
                    '#8cff00',
                    '#88ff00',
                    '#83ff00',
                    '#7fff00',
                    '#7bff00',
                    '#77ff00',
                    '#72ff00',
                    '#6eff00',
                    '#6aff00',
                    '#65ff00',
                    '#61ff00',
                    '#5dff00',
                    '#59ff00',
                    '#54ff00',
                    '#50ff00',
                    '#4cff00',
                    '#48ff00',
                    '#44ff00',
                    '#3fff00',
                    '#3bff00',
                    '#37ff00',
                    '#33ff00',
                    '#2eff00',
                    '#2aff00',
                    '#26ff00',
                    '#21ff00',
                    '#1dff00',
                    '#19ff00',
                    '#15ff00',
                    '#10ff00',
                    '#0cff00',
                    '#08ff00',
                    '#04ff00',
                    '#00ff00',
                    '#00ff04',
                    '#00ff08',
                    '#00ff0c',
                    '#00ff10',
                    '#00ff15',
                    '#00ff19',
                    '#00ff1d',
                    '#00ff21',
                    '#00ff26',
                    '#00ff2a',
                    '#00ff2e',
                    '#00ff32',
                    '#00ff37',
                    '#00ff3b',
                    '#00ff3f',
                    '#00ff43',
                    '#00ff48',
                    '#00ff4c',
                    '#00ff50',
                    '#00ff55',
                    '#00ff59',
                    '#00ff5d',
                    '#00ff61',
                    '#00ff66',
                    '#00ff6a',
                    '#00ff6e',
                    '#00ff72',
                    '#00ff77',
                    '#00ff7b',
                    '#00ff7f',
                    '#00ff83',
                    '#00ff87',
                    '#00ff8c',
                    '#00ff90',
                    '#00ff94',
                    '#00ff99',
                    '#00ff9d',
                    '#00ffa1',
                    '#00ffa5',
                    '#00ffa9',
                    '#00ffae',
                    '#00ffb2',
                    '#00ffb6',
                    '#00ffbb',
                    '#00ffbf',
                    '#00ffc3',
                    '#00ffc7',
                    '#00ffcb',
                    '#00ffd0',
                    '#00ffd4',
                    '#00ffd8',
                    '#00ffdd',
                    '#00ffe1',
                    '#00ffe5',
                    '#00ffe9',
                    '#00ffed',
                    '#00fff2',
                    '#00fff6',
                    '#00fffa',
                    '#00ffff',
                    '#00faff',
                    '#00f6ff',
                    '#00f2ff',
                    '#00eeff',
                    '#00e9ff',
                    '#00e5ff',
                    '#00e1ff',
                    '#00dcff',
                    '#00d8ff',
                    '#00d4ff',
                    '#00d0ff',
                    '#00cbff',
                    '#00c7ff',
                    '#00c3ff',
                    '#00bfff',
                    '#00bbff',
                    '#00b6ff',
                    '#00b2ff',
                    '#00aeff',
                    '#00a9ff',
                    '#00a5ff',
                    '#00a1ff',
                    '#009dff',
                    '#0099ff',
                    '#0094ff',
                    '#0090ff',
                    '#008cff',
                    '#0088ff',
                    '#0083ff',
                    '#007fff',
                    '#007bff',
                    '#0077ff',
                    '#0072ff',
                    '#006eff',
                    '#006aff',
                    '#0066ff',
                    '#0061ff',
                    '#005dff',
                    '#0059ff',
                    '#0054ff',
                    '#0050ff',
                    '#004cff',
                    '#0048ff',
                    '#0043ff',
                    '#003fff',
                    '#003bff',
                    '#0037ff',
                    '#0033ff',
                    '#002eff',
                    '#002aff',
                    '#0026ff',
                    '#0021ff',
                    '#001dff',
                    '#0019ff',
                    '#0015ff',
                    '#0010ff',
                    '#000cff',
                    '#0008ff',
                    '#0004ff',
                    '#0000ff',
                    '#0400ff',
                    '#0800ff',
                    '#0c00ff',
                    '#1000ff',
                    '#1500ff',
                    '#1900ff',
                    '#1d00ff',
                    '#2100ff',
                    '#2600ff',
                    '#2a00ff',
                    '#2e00ff',
                    '#3200ff',
                    '#3700ff',
                    '#3b00ff',
                    '#3f00ff',
                    '#4300ff',
                    '#4800ff',
                    '#4c00ff',
                    '#5000ff',
                    '#5400ff',
                    '#5900ff',
                    '#5d00ff',
                    '#6100ff',
                    '#6500ff',
                    '#6a00ff',
                    '#6e00ff',
                    '#7200ff',
                    '#7700ff',
                    '#7b00ff',
                    '#7f00ff',
                    '#8300ff',
                    '#8700ff',
                    '#8c00ff',
                    '#9000ff',
                    '#9400ff',
                    '#9900ff',
                    '#9d00ff',
                    '#a100ff',
                    '#a500ff',
                    '#aa00ff',
                    '#ae00ff',
                    '#b200ff',
                    '#b600ff',
                    '#bb00ff',
                    '#bf00ff',
                    '#c300ff',
                    '#c700ff',
                    '#cc00ff',
                    '#d000ff',
                    '#d400ff',
                    '#d800ff',
                    '#dd00ff',
                    '#e100ff',
                    '#e500ff',
                    '#e900ff',
                    '#ee00ff',
                    '#f200ff',
                    '#f600ff',
                    '#fa00ff',
                    '#ff00ff',
                    '#ff00fa',
                    '#ff00f6',
                    '#ff00f2',
                    '#ff00ee',
                    '#ff00e9',
                    '#ff00e5',
                    '#ff00e1',
                    '#ff00dd',
                    '#ff00d8',
                    '#ff00d4',
                    '#ff00d0',
                    '#ff00cb',
                    '#ff00c7',
                    '#ff00c3',
                    '#ff00bf',
                    '#ff00bb',
                    '#ff00b6',
                    '#ff00b2',
                    '#ff00ae',
                    '#ff00aa',
                    '#ff00a5',
                    '#ff00a1',
                    '#ff009d',
                    '#ff0098',
                    '#ff0094',
                    '#ff0090',
                    '#ff008c',
                    '#ff0087',
                    '#ff0083',
                    '#ff007f',
                    '#ff007b',
                    '#ff0077',
                    '#ff0072',
                    '#ff006e',
                    '#ff006a',
                    '#ff0066',
                    '#ff0061',
                    '#ff005d',
                    '#ff0059',
                    '#ff0055',
                    '#ff0050',
                    '#ff004c',
                    '#ff0048',
                    '#ff0043',
                    '#ff003f',
                    '#ff003b',
                    '#ff0037',
                    '#ff0033',
                    '#ff002e',
                    '#ff002a',
                    '#ff0026',
                    '#ff0022',
                    '#ff001d',
                    '#ff0019',
                    '#ff0015',
                    '#ff0010',
                    '#ff000c',
                    '#ff0008',
                    '#ff0004',
                ],
                default => self::PATTERN,
            };
    }
}
