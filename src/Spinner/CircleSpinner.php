<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class CircleSpinner extends AbstractSpinner
{
    /**
     * @return Circular
     */
    protected function getSymbols(): Circular
    {
        return new Circular([
            '◜',
            '◠',
            '◝',
            '◞',
            '◡',
            '◟',
//            '◴',
//            '◐',
//            '◷',
//            '◓',
//            '◶',
//            '◑',
//            '◵',
//            '◒',
        ]);
    }
}
