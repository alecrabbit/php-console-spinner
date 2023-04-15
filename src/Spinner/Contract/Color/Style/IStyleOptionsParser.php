<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Contract\Color\Style;

use IteratorAggregate;

interface IStyleOptionsParser
{
    public function parseOptions(?IStyleOptions $options): iterable;
}
