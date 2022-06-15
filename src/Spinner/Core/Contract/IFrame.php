<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use Stringable;

interface IFrame extends Stringable
{
    public static function create(mixed $element, ?int $elementWidth): IFrame;
}
