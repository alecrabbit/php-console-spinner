<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

final class FeatheredArrow extends AReversiblePattern
{
    protected const UPDATE_INTERVAL = 160;

    protected function pattern(): iterable
    {
        return [
            '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
            '➴', // BLACK-FEATHERED SOUTH EAST ARROW
            '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
            '➶', // BLACK-FEATHERED NORTH EAST ARROW
            '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
            '➷', // HEAVY BLACK-FEATHERED SOUTH EAST ARROW
            '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
            '➹', // HEAVY BLACK-FEATHERED NORTH EAST ARROW
        ];
    }
}