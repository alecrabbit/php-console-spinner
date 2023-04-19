<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\ALegacyPattern;
use ArrayObject;
use Traversable;

/** @psalm-suppress UnusedClass */
final class FingerDance extends ALegacyPattern
{
    protected const INTERVAL = 300;

    protected const PATTERN = [
        '🤘 ',
        '🤟 ',
        '🖖 ',
        '✋ ',
        '🤚 ',
        '👆 ',
    ];

    protected function entries(): Traversable
    {
        return new ArrayObject(self::PATTERN);
    }
}
