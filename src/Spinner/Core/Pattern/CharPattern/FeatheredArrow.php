<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use ArrayObject;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class FeatheredArrow extends AReversiblePattern
{
    protected const INTERVAL = 160;
    protected const PATTERN = [
        '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
        '➴', // BLACK-FEATHERED SOUTH EAST ARROW
        '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
        '➶', // BLACK-FEATHERED NORTH EAST ARROW
        '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
        '➷', // HEAVY BLACK-FEATHERED SOUTH EAST ARROW
        '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
        '➹', // HEAVY BLACK-FEATHERED NORTH EAST ARROW
    ];

    public function __construct(
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct(
            new ArrayObject(self::PATTERN),
            $interval ?? self::INTERVAL,
            $reversed
        );
    }

}
