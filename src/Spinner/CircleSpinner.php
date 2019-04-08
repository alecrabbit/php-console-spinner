<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class CircleSpinner extends AbstractSpinner
{
    /** {@inheritDoc} */
    protected function getSymbols(): array
    {
        return [
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
        ];
    }
}
