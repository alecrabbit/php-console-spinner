<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Contract\Color\Style;

use IteratorAggregate;

interface IStyleOptions extends IteratorAggregate
{
    public function isEmpty(): bool;
}
