<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

use function sprintf;

final class Rainbow extends AStylePalette
{
    /**
     * @return Traversable<IStyleFrame>
     */
    protected function ansi4StyleFrames(): Traversable
    {
        yield from [
            $this->createFrame("\e[96m%s\e[39m"),
        ];
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, 0);
    }

    /**
     * @return Traversable<IStyleFrame>
     */
    protected function ansi8StyleFrames(): Traversable
    {
        /** @var string $item */
        foreach ($this->ansi8Sequence() as $item) {
            $element = sprintf("\e[38;5;%sm%%s\e[39m", $item);
            yield $this->createFrame($element);
        }
    }

    /**
     * @return Traversable<string>
     */
    private function ansi8Sequence(): Traversable
    {
        yield from [
            '196',
            '208',
            '214',
            '220',
            '226',
            '190',
            '154',
            '118',
            '82',
            '46',
            '47',
            '48',
            '49',
            '50',
            '51',
            '45',
            '39',
            '33',
            '27',
            '56',
            '57',
            '93',
            '129',
            '165',
            '201',
            '200',
            '199',
            '198',
            '197',
        ];
    }

    /**
     * @return Traversable<IStyleFrame>
     */
    protected function ansi24StyleFrames(): Traversable
    {
        /** @var string $item */
        foreach ($this->ansi24Sequence() as $item) {
            $element = sprintf("\e[38;2;%sm%%s\e[39m", $item);
            yield $this->createFrame($element);
        }
    }

    /**
     * @return Traversable<string>
     */
    private function ansi24Sequence(): Traversable
    {
        yield from $this->ansi24part1();
        yield from $this->ansi24part2();
        yield from $this->ansi24part3();
    }

    /**
     * @return Traversable<string>
     */
    private function ansi24part1(): Traversable
    {
        yield from [
            '255;0;0',
            '255;4;0',
            '255;8;0',
            '255;12;0',
            '255;16;0',
            '255;21;0',
            '255;25;0',
            '255;29;0',
            '255;33;0',
            '255;38;0',
            '255;42;0',
            '255;46;0',
            '255;50;0',
            '255;55;0',
            '255;59;0',
            '255;63;0',
            '255;67;0',
            '255;72;0',
            '255;76;0',
            '255;80;0',
            '255;84;0',
            '255;89;0',
            '255;93;0',
            '255;97;0',
            '255;102;0',
            '255;106;0',
            '255;110;0',
            '255;114;0',
            '255;119;0',
            '255;123;0',
            '255;127;0',
            '255;131;0',
            '255;136;0',
            '255;140;0',
            '255;144;0',
            '255;148;0',
            '255;153;0',
            '255;157;0',
            '255;161;0',
            '255;165;0',
            '255;170;0',
            '255;174;0',
            '255;178;0',
            '255;182;0',
            '255;187;0',
            '255;191;0',
            '255;195;0',
            '255;199;0',
            '255;204;0',
            '255;208;0',
            '255;212;0',
            '255;216;0',
            '255;220;0',
            '255;225;0',
            '255;229;0',
            '255;233;0',
            '255;238;0',
            '255;242;0',
            '255;246;0',
            '255;250;0',
            '255;255;0',
            '250;255;0',
            '246;255;0',
            '242;255;0',
            '238;255;0',
            '233;255;0',
            '229;255;0',
            '225;255;0',
            '221;255;0',
            '216;255;0',
            '212;255;0',
            '208;255;0',
            '203;255;0',
            '199;255;0',
            '195;255;0',
            '191;255;0',
            '187;255;0',
            '182;255;0',
            '178;255;0',
            '174;255;0',
            '170;255;0',
            '165;255;0',
            '161;255;0',
            '157;255;0',
            '153;255;0',
            '148;255;0',
            '144;255;0',
            '140;255;0',
            '136;255;0',
            '131;255;0',
            '127;255;0',
            '123;255;0',
            '119;255;0',
            '114;255;0',
            '110;255;0',
            '106;255;0',
            '101;255;0',
            '97;255;0',
            '93;255;0',
            '89;255;0',
            '84;255;0',
            '80;255;0',
            '76;255;0',
            '72;255;0',
            '68;255;0',
            '63;255;0',
            '59;255;0',
            '55;255;0',
            '51;255;0',
            '46;255;0',
            '42;255;0',
            '38;255;0',
            '33;255;0',
            '29;255;0',
            '25;255;0',
            '21;255;0',
            '16;255;0',
            '12;255;0',
            '8;255;0',
            '4;255;0',
        ];
    }

    /**
     * @return Traversable<string>
     */
    private function ansi24part2(): Traversable
    {
        yield from [
            '0;255;0',
            '0;255;4',
            '0;255;8',
            '0;255;12',
            '0;255;16',
            '0;255;21',
            '0;255;25',
            '0;255;29',
            '0;255;33',
            '0;255;38',
            '0;255;42',
            '0;255;46',
            '0;255;50',
            '0;255;55',
            '0;255;59',
            '0;255;63',
            '0;255;67',
            '0;255;72',
            '0;255;76',
            '0;255;80',
            '0;255;85',
            '0;255;89',
            '0;255;93',
            '0;255;97',
            '0;255;102',
            '0;255;106',
            '0;255;110',
            '0;255;114',
            '0;255;119',
            '0;255;123',
            '0;255;127',
            '0;255;131',
            '0;255;135',
            '0;255;140',
            '0;255;144',
            '0;255;148',
            '0;255;153',
            '0;255;157',
            '0;255;161',
            '0;255;165',
            '0;255;169',
            '0;255;174',
            '0;255;178',
            '0;255;182',
            '0;255;187',
            '0;255;191',
            '0;255;195',
            '0;255;199',
            '0;255;203',
            '0;255;208',
            '0;255;212',
            '0;255;216',
            '0;255;221',
            '0;255;225',
            '0;255;229',
            '0;255;233',
            '0;255;237',
            '0;255;242',
            '0;255;246',
            '0;255;250',
            '0;255;255',
            '0;250;255',
            '0;246;255',
            '0;242;255',
            '0;238;255',
            '0;233;255',
            '0;229;255',
            '0;225;255',
            '0;220;255',
            '0;216;255',
            '0;212;255',
            '0;208;255',
            '0;203;255',
            '0;199;255',
            '0;195;255',
            '0;191;255',
            '0;187;255',
            '0;182;255',
            '0;178;255',
            '0;174;255',
            '0;169;255',
            '0;165;255',
            '0;161;255',
            '0;157;255',
            '0;153;255',
            '0;148;255',
            '0;144;255',
            '0;140;255',
            '0;136;255',
            '0;131;255',
            '0;127;255',
            '0;123;255',
            '0;119;255',
            '0;114;255',
            '0;110;255',
            '0;106;255',
            '0;102;255',
            '0;97;255',
            '0;93;255',
            '0;89;255',
            '0;84;255',
            '0;80;255',
            '0;76;255',
            '0;72;255',
            '0;67;255',
            '0;63;255',
            '0;59;255',
            '0;55;255',
            '0;51;255',
            '0;46;255',
            '0;42;255',
            '0;38;255',
            '0;33;255',
            '0;29;255',
            '0;25;255',
            '0;21;255',
            '0;16;255',
            '0;12;255',
            '0;8;255',
            '0;4;255',
        ];
    }

    /**
     * @return Traversable<string>
     */
    private function ansi24part3(): Traversable
    {
        yield from [
            '0;0;255',
            '4;0;255',
            '8;0;255',
            '12;0;255',
            '16;0;255',
            '21;0;255',
            '25;0;255',
            '29;0;255',
            '33;0;255',
            '38;0;255',
            '42;0;255',
            '46;0;255',
            '50;0;255',
            '55;0;255',
            '59;0;255',
            '63;0;255',
            '67;0;255',
            '72;0;255',
            '76;0;255',
            '80;0;255',
            '84;0;255',
            '89;0;255',
            '93;0;255',
            '97;0;255',
            '101;0;255',
            '106;0;255',
            '110;0;255',
            '114;0;255',
            '119;0;255',
            '123;0;255',
            '127;0;255',
            '131;0;255',
            '135;0;255',
            '140;0;255',
            '144;0;255',
            '148;0;255',
            '153;0;255',
            '157;0;255',
            '161;0;255',
            '165;0;255',
            '170;0;255',
            '174;0;255',
            '178;0;255',
            '182;0;255',
            '187;0;255',
            '191;0;255',
            '195;0;255',
            '199;0;255',
            '204;0;255',
            '208;0;255',
            '212;0;255',
            '216;0;255',
            '221;0;255',
            '225;0;255',
            '229;0;255',
            '233;0;255',
            '238;0;255',
            '242;0;255',
            '246;0;255',
            '250;0;255',
            '255;0;255',
            '255;0;250',
            '255;0;246',
            '255;0;242',
            '255;0;238',
            '255;0;233',
            '255;0;229',
            '255;0;225',
            '255;0;221',
            '255;0;216',
            '255;0;212',
            '255;0;208',
            '255;0;203',
            '255;0;199',
            '255;0;195',
            '255;0;191',
            '255;0;187',
            '255;0;182',
            '255;0;178',
            '255;0;174',
            '255;0;170',
            '255;0;165',
            '255;0;161',
            '255;0;157',
            '255;0;152',
            '255;0;148',
            '255;0;144',
            '255;0;140',
            '255;0;135',
            '255;0;131',
            '255;0;127',
            '255;0;123',
            '255;0;119',
            '255;0;114',
            '255;0;110',
            '255;0;106',
            '255;0;102',
            '255;0;97',
            '255;0;93',
            '255;0;89',
            '255;0;85',
            '255;0;80',
            '255;0;76',
            '255;0;72',
            '255;0;67',
            '255;0;63',
            '255;0;59',
            '255;0;55',
            '255;0;51',
            '255;0;46',
            '255;0;42',
            '255;0;38',
            '255;0;34',
            '255;0;29',
            '255;0;25',
            '255;0;21',
            '255;0;16',
            '255;0;12',
            '255;0;8',
            '255;0;4',
        ];
    }
}
